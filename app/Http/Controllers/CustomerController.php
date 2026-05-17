<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Tag;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Customer::class);

        $user = Auth::user();
        $query = Customer::with(['assignedTo', 'tags']);

        // Sales executives only see customers assigned to them
        // Support agents see all customers (to handle issues)
        if ($user->isSalesExecutive() && !$user->isAdmin() && !$user->isManager()) {
            $query->where('assigned_to', $user->id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('company', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->assigned_to && $user->canViewAll()) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $customers = $query->latest()->paginate(15);
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect();

        return view('customers.index', compact('customers', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Customer::class);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $tags = Tag::all();
        $languages = config('languages.supported');
        return view('customers.create', compact('users', 'tags', 'languages'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Customer::class);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'company'            => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'mobile'             => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'city'               => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'country'            => 'nullable|string|max:100',
            'pincode'            => 'nullable|string|max:10',
            'website'            => 'nullable|url|max:255',
            'industry'           => 'nullable|string|max:100',
            'source'             => 'nullable|string|max:100',
            'status'             => 'required|in:active,inactive,prospect,churned',
            'preferred_language' => 'nullable|string|max:5',
            'notes'              => 'nullable|string',
            'assigned_to'        => 'nullable|exists:users,id',
            'tags'               => 'nullable|array',
        ]);

        $user = Auth::user();
        $validated['created_by'] = $user->id;

        // Agents can only assign customers to themselves
        if (!$user->canViewAll()) {
            $validated['assigned_to'] = $user->id;
        }

        $customer = Customer::create($validated);

        if ($request->tags) {
            $customer->tags()->sync($request->tags);
        }

        // Notify the assigned user
        if (!empty($validated['assigned_to'])) {
            NotificationService::customerAssigned(
                $validated['assigned_to'],
                $customer->name,
                $customer->id,
                Auth::id()
            );
        }

        Activity::create([
            'type'         => 'created',
            'description'  => "Customer '{$customer->name}' was created",
            'subject_type' => Customer::class,
            'subject_id'   => $customer->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('customers.show', $customer)
            ->with('success', __('messages.customer_created'));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        $customer->load(['contacts', 'leads', 'deals', 'tasks', 'noteRecords.createdBy', 'activities.causer', 'tags', 'assignedTo']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);

        $user = Auth::user();
        $users = $user->canViewAll() ? User::where('is_active', true)->get() : collect([$user]);
        $tags = Tag::all();
        $languages = config('languages.supported');
        return view('customers.edit', compact('customer', 'users', 'tags', 'languages'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'company'            => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'mobile'             => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'city'               => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'country'            => 'nullable|string|max:100',
            'pincode'            => 'nullable|string|max:10',
            'website'            => 'nullable|url|max:255',
            'industry'           => 'nullable|string|max:100',
            'source'             => 'nullable|string|max:100',
            'status'             => 'required|in:active,inactive,prospect,churned',
            'preferred_language' => 'nullable|string|max:5',
            'notes'              => 'nullable|string',
            'assigned_to'        => 'nullable|exists:users,id',
            'tags'               => 'nullable|array',
        ]);

        // Agents cannot reassign customers
        if (!Auth::user()->canViewAll()) {
            unset($validated['assigned_to']);
        }

        $oldAssignee = $customer->assigned_to;
        $customer->update($validated);

        if ($request->has('tags')) {
            $customer->tags()->sync($request->tags ?? []);
        }

        // Notify if reassigned to a new user
        $newAssignee = $customer->fresh()->assigned_to;
        if ($newAssignee && $newAssignee !== $oldAssignee) {
            NotificationService::customerAssigned($newAssignee, $customer->name, $customer->id, Auth::id());
        }

        Activity::create([
            'type'         => 'updated',
            'description'  => "Customer '{$customer->name}' was updated",
            'subject_type' => Customer::class,
            'subject_id'   => $customer->id,
            'causer_id'    => Auth::id(),
        ]);

        return redirect()->route('customers.show', $customer)
            ->with('success', __('messages.customer_updated'));
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', __('messages.customer_deleted'));
    }
}
