<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Task;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $user = Auth::user();
        $query = Task::with(['assignedTo', 'taskable']);

        // Agents only see tasks assigned to them or created by them
        if (!$user->canViewAll()) {
            $query->where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            });
        }

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);

        // Managers can filter by team member
        if ($request->assigned_to && $user->canViewAll()) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query->orderBy('due_date')->paginate(20);
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect();

        return view('tasks.index', compact('tasks', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $user = Auth::user();
        // Admins/managers can assign to anyone; agents assign to themselves
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:call,email,meeting,follow_up,demo,other',
            'status'      => 'required|in:pending,in_progress,completed,cancelled',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        $validated['created_by'] = $user->id;

        // Agents can only assign tasks to themselves
        if (!$user->canViewAll()) {
            $validated['assigned_to'] = $user->id;
        }

        $task = Task::create($validated);

        // Notify the assigned user
        if (!empty($validated['assigned_to'])) {
            $dueDate = $task->due_date ? $task->due_date->format('d M Y') : null;
            NotificationService::taskAssigned(
                $validated['assigned_to'],
                $task->title,
                $task->id,
                Auth::id(),
                $dueDate
            );
        }

        Activity::create([
            'type'         => 'created',
            'description'  => "Task '{$task->title}' was created",
            'subject_type' => Task::class,
            'subject_id'   => $task->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('tasks.index')->with('success', __('messages.task_created'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:call,email,meeting,follow_up,demo,other',
            'status'      => 'required|in:pending,in_progress,completed,cancelled',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        // Agents cannot reassign tasks
        if (!Auth::user()->canViewAll()) {
            unset($validated['assigned_to']);
        }

        $oldAssignee = $task->assigned_to;
        $wasCompleted = $task->status === 'completed';
        $task->update($validated);

        // Notify if reassigned to a new user
        $newAssignee = $task->fresh()->assigned_to;
        if ($newAssignee && $newAssignee !== $oldAssignee) {
            $dueDate = $task->due_date ? $task->due_date->format('d M Y') : null;
            NotificationService::taskAssigned($newAssignee, $task->title, $task->id, Auth::id(), $dueDate);
        }

        // Notify task creator when task is completed by someone else
        if (!$wasCompleted && $task->fresh()->status === 'completed' && $task->created_by) {
            NotificationService::taskCompleted($task->created_by, Auth::id(), $task->title, $task->id);
        }

        return redirect()->route('tasks.index')->with('success', __('messages.task_updated'));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('tasks.index')->with('success', __('messages.task_deleted'));
    }

    public function complete(Task $task)
    {
        $this->authorize('complete', $task);

        $task->update(['status' => 'completed', 'completed_at' => now()]);

        // Notify the task creator if completed by someone else
        if ($task->created_by && $task->created_by !== Auth::id()) {
            NotificationService::taskCompleted($task->created_by, Auth::id(), $task->title, $task->id);
        }

        return back()->with('success', __('messages.task_completed'));
    }
}
