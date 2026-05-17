<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Contact::class);

        $query = Contact::with('customer');
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        $contacts = $query->latest()->paginate(15);
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $this->authorize('create', Contact::class);

        $customers = Customer::orderBy('name')->get();
        $languages = config('languages.supported');
        return view('contacts.create', compact('customers', 'languages'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Contact::class);

        $validated = $request->validate([
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'job_title'          => 'nullable|string|max:100',
            'customer_id'        => 'nullable|exists:customers,id',
            'preferred_language' => 'nullable|string|max:5',
            'notes'              => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $contact = Contact::create($validated);

        return redirect()->route('contacts.show', $contact)->with('success', __('messages.contact_created'));
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        $contact->load('customer');
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        $customers = Customer::orderBy('name')->get();
        $languages = config('languages.supported');
        return view('contacts.edit', compact('contact', 'customers', 'languages'));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'job_title'          => 'nullable|string|max:100',
            'customer_id'        => 'nullable|exists:customers,id',
            'preferred_language' => 'nullable|string|max:5',
            'notes'              => 'nullable|string',
        ]);

        $contact->update($validated);
        return redirect()->route('contacts.show', $contact)->with('success', __('messages.contact_updated'));
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();
        return redirect()->route('contacts.index')->with('success', __('messages.contact_deleted'));
    }
}
