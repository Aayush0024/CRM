<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Lead::class);

        $user = Auth::user();
        $query = Lead::with(['assignedTo', 'customer']);

        // Sales executives only see their own leads
        if ($user->isSalesExecutive() && !$user->isAdmin() && !$user->isManager()) {
            $query->where('assigned_to', $user->id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('company', 'like', "%{$request->search}%");
            });
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);

        // Managers can filter by assigned user
        if ($request->assigned_to && $user->canViewAll()) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $leads = $query->latest()->paginate(15);

        // Only admins/managers can assign to other users
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect();

        return view('leads.index', compact('leads', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Lead::class);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $customers = Customer::orderBy('name')->get();
        return view('leads.create', compact('users', 'customers'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'name'                => 'required|string|max:255',
            'email'               => 'nullable|email|max:255',
            'phone'               => 'nullable|string|max:20',
            'company'             => 'nullable|string|max:255',
            'status'              => 'required|in:new,contacted,qualified,unqualified',
            'priority'            => 'required|in:low,medium,high',
            'source'              => 'nullable|string|max:100',
            'estimated_value'     => 'nullable|numeric|min:0',
            'currency'            => 'nullable|string|max:5',
            'description'         => 'nullable|string',
            'customer_id'         => 'nullable|exists:customers,id',
            'assigned_to'         => 'nullable|exists:users,id',
            'expected_close_date' => 'nullable|date',
        ]);

        $user = Auth::user();
        $validated['created_by'] = $user->id;

        // Agents can only assign leads to themselves
        if (!$user->canViewAll()) {
            $validated['assigned_to'] = $user->id;
        }

        $lead = Lead::create($validated);

        // Notify the assigned user
        if (!empty($validated['assigned_to'])) {
            NotificationService::leadAssigned(
                $validated['assigned_to'],
                $lead->title,
                $lead->id,
                Auth::id()
            );
        }

        Activity::create([
            'type'         => 'created',
            'description'  => "Lead '{$lead->title}' was created",
            'subject_type' => Lead::class,
            'subject_id'   => $lead->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('leads.show', $lead)->with('success', __('messages.lead_created'));
    }

    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);

        $lead->load(['assignedTo', 'customer', 'notes.createdBy', 'activities.causer']);
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $this->authorize('update', $lead);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $customers = Customer::orderBy('name')->get();
        return view('leads.edit', compact('lead', 'users', 'customers'));
    }

    public function update(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'name'                => 'required|string|max:255',
            'email'               => 'nullable|email|max:255',
            'phone'               => 'nullable|string|max:20',
            'company'             => 'nullable|string|max:255',
            'status'              => 'required|in:new,contacted,qualified,unqualified,converted,lost',
            'priority'            => 'required|in:low,medium,high',
            'source'              => 'nullable|string|max:100',
            'estimated_value'     => 'nullable|numeric|min:0',
            'currency'            => 'nullable|string|max:5',
            'description'         => 'nullable|string',
            'customer_id'         => 'nullable|exists:customers,id',
            'assigned_to'         => 'nullable|exists:users,id',
            'expected_close_date' => 'nullable|date',
        ]);

        // Agents cannot reassign leads
        if (!Auth::user()->canViewAll()) {
            unset($validated['assigned_to']);
        }

        $oldAssignee  = $lead->assigned_to;
        $oldStatus    = $lead->status;
        $lead->update($validated);

        // Notify if reassigned to a different user
        $newAssignee = $lead->fresh()->assigned_to;
        if ($newAssignee && $newAssignee !== $oldAssignee) {
            NotificationService::leadAssigned($newAssignee, $lead->title, $lead->id, Auth::id());
        }

        // Notify assignee if status changed by someone else
        if (isset($validated['status']) && $validated['status'] !== $oldStatus && $lead->assigned_to) {
            NotificationService::leadStatusChanged(
                $lead->assigned_to,
                Auth::id(),
                $lead->title,
                $validated['status'],
                $lead->id
            );
        }

        Activity::create([
            'type'         => 'updated',
            'description'  => "Lead '{$lead->title}' was updated",
            'subject_type' => Lead::class,
            'subject_id'   => $lead->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('leads.show', $lead)->with('success', __('messages.lead_updated'));
    }

    public function destroy(Lead $lead)
    {
        $this->authorize('delete', $lead);

        $lead->delete();
        return redirect()->route('leads.index')->with('success', __('messages.lead_deleted'));
    }

    public function convert(Lead $lead)
    {
        $this->authorize('convert', $lead);

        $deal = Deal::create([
            'title'               => $lead->title,
            'value'               => $lead->estimated_value ?? 0,
            'currency'            => $lead->currency ?? 'INR',
            'stage'               => 'prospecting',
            'probability'         => 20,
            'expected_close_date' => $lead->expected_close_date,
            'status'              => 'open',
            'description'         => $lead->description,
            'customer_id'         => $lead->customer_id,
            'lead_id'             => $lead->id,
            'assigned_to'         => $lead->assigned_to,
            'created_by'          => Auth::id(),
        ]);

        $lead->update(['status' => 'converted', 'converted_at' => now()]);

        // Notify creator and assignee about the conversion
        NotificationService::leadConverted(
            $lead->created_by,
            $lead->assigned_to,
            $lead->title,
            $deal->id
        );

        Activity::create([
            'type'         => 'converted',
            'description'  => "Lead '{$lead->title}' was converted to deal",
            'subject_type' => Lead::class,
            'subject_id'   => $lead->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('deals.show', $deal)->with('success', __('messages.lead_converted'));
    }
}
