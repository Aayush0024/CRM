<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Deal::class);

        $user = Auth::user();
        $query = Deal::with(['customer', 'assignedTo']);

        // Sales executives only see their own deals
        if ($user->isSalesExecutive() && !$user->isAdmin() && !$user->isManager()) {
            $query->where('assigned_to', $user->id);
        }

        // Managers can filter by team member
        if ($request->assigned_to && $user->canViewAll()) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $deals = $query->latest()->get();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect();

        return view('deals.index', compact('deals', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Deal::class);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $customers = Customer::orderBy('name')->get();
        return view('deals.create', compact('users', 'customers'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Deal::class);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'value'               => 'nullable|numeric|min:0',
            'currency'            => 'nullable|string|max:5',
            'stage'               => 'required|in:prospecting,qualification,proposal,negotiation,closed_won,closed_lost',
            'probability'         => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'status'              => 'nullable|string',
            'description'         => 'nullable|string',
            'lost_reason'         => 'nullable|string',
            'customer_id'         => 'nullable|exists:customers,id',
            'assigned_to'         => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        $validated['created_by'] = $user->id;
        $validated['status'] = $validated['stage'] === 'closed_won' ? 'won'
            : ($validated['stage'] === 'closed_lost' ? 'lost' : 'open');
        $validated['value'] = $validated['value'] ?? 0;

        // Agents can only assign deals to themselves
        if (!$user->canViewAll()) {
            $validated['assigned_to'] = $user->id;
        }

        $deal = Deal::create($validated);

        // Notify the assigned user
        if (!empty($validated['assigned_to'])) {
            NotificationService::dealAssigned(
                $validated['assigned_to'],
                $deal->title,
                $deal->id,
                Auth::id()
            );
        }

        // Notify if deal is immediately won
        if ($deal->status === 'won') {
            NotificationService::dealWon($deal->assigned_to, $deal->created_by, $deal->title, $deal->id);
        }

        Activity::create([
            'type'         => 'created',
            'description'  => "Deal '{$deal->title}' was created",
            'subject_type' => Deal::class,
            'subject_id'   => $deal->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('deals.show', $deal)->with('success', __('messages.deal_created'));
    }

    public function show(Deal $deal)
    {
        $this->authorize('view', $deal);

        $deal->load(['customer', 'assignedTo', 'notes.createdBy', 'activities.causer']);
        return view('deals.show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $this->authorize('update', $deal);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $customers = Customer::orderBy('name')->get();
        return view('deals.edit', compact('deal', 'users', 'customers'));
    }

    public function update(Request $request, Deal $deal)
    {
        $this->authorize('update', $deal);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'value'               => 'nullable|numeric|min:0',
            'currency'            => 'nullable|string|max:5',
            'stage'               => 'required|in:prospecting,qualification,proposal,negotiation,closed_won,closed_lost',
            'probability'         => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'description'         => 'nullable|string',
            'lost_reason'         => 'nullable|string',
            'customer_id'         => 'nullable|exists:customers,id',
            'assigned_to'         => 'nullable|exists:users,id',
        ]);

        $validated['status'] = $validated['stage'] === 'closed_won' ? 'won'
            : ($validated['stage'] === 'closed_lost' ? 'lost' : 'open');
        $validated['value'] = $validated['value'] ?? 0;

        // Agents cannot reassign deals
        if (!Auth::user()->canViewAll()) {
            unset($validated['assigned_to']);
        }

        $oldAssignee = $deal->assigned_to;
        $oldStatus   = $deal->status;
        $deal->update($validated);

        $deal->refresh();

        // Notify if reassigned
        if ($deal->assigned_to && $deal->assigned_to !== $oldAssignee) {
            NotificationService::dealAssigned($deal->assigned_to, $deal->title, $deal->id, Auth::id());
        }

        // Notify on status transitions
        if ($deal->status !== $oldStatus) {
            if ($deal->status === 'won') {
                NotificationService::dealWon($deal->assigned_to, $deal->created_by, $deal->title, $deal->id);
            } elseif ($deal->status === 'lost' && $deal->assigned_to) {
                NotificationService::dealLost($deal->assigned_to, Auth::id(), $deal->title, $deal->id);
            }
        }

        // Notify assignee of stage change (if changed by someone else)
        if (isset($validated['stage']) && $deal->assigned_to && $deal->assigned_to !== Auth::id()) {
            NotificationService::dealStageChanged($deal->assigned_to, Auth::id(), $deal->title, $deal->stage, $deal->id);
        }

        Activity::create([
            'type'         => 'updated',
            'description'  => "Deal '{$deal->title}' was updated",
            'subject_type' => Deal::class,
            'subject_id'   => $deal->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('deals.show', $deal)->with('success', __('messages.deal_updated'));
    }

    public function destroy(Deal $deal)
    {
        $this->authorize('delete', $deal);

        $deal->delete();
        return redirect()->route('deals.index')->with('success', __('messages.deal_deleted'));
    }

    public function updateStage(Request $request, Deal $deal)
    {
        $this->authorize('updateStage', $deal);

        $request->validate(['stage' => 'required|in:prospecting,qualification,proposal,negotiation,closed_won,closed_lost']);

        $oldStatus = $deal->status;
        $deal->update([
            'stage'  => $request->stage,
            'status' => $request->stage === 'closed_won' ? 'won'
                : ($request->stage === 'closed_lost' ? 'lost' : 'open'),
        ]);

        $deal->refresh();

        // Notify on stage change
        if ($deal->assigned_to && $deal->assigned_to !== Auth::id()) {
            NotificationService::dealStageChanged($deal->assigned_to, Auth::id(), $deal->title, $deal->stage, $deal->id);
        }

        if ($deal->status !== $oldStatus) {
            if ($deal->status === 'won') {
                NotificationService::dealWon($deal->assigned_to, $deal->created_by, $deal->title, $deal->id);
            } elseif ($deal->status === 'lost' && $deal->assigned_to) {
                NotificationService::dealLost($deal->assigned_to, Auth::id(), $deal->title, $deal->id);
            }
        }

        return response()->json(['success' => true]);
    }
}
