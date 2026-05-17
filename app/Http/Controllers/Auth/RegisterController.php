<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Anyone can register. Every registrant becomes an Admin —
     * the owner of their own CRM account. They then create
     * employees (Sales Manager, Sales Executive, Support Agent)
     * from the Users panel.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'email'               => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'            => ['required', 'string', 'min:8', 'confirmed'],
            'language_preference' => ['nullable', 'string', 'max:5'],
        ]);

        // Every new registrant becomes an Admin (CRM owner)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description'  => 'Full access — create users, assign roles, reset passwords, disable accounts, view reports, configure CRM',
            ]
        );

        $user = User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'language_preference' => $validated['language_preference'] ?? 'en',
            'role_id'             => $adminRole->id,
            'is_active'           => true,
        ]);

        Auth::login($user);
        session(['locale' => $user->language_preference]);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! Your CRM account is ready. You can now create your team from the Users panel.');
    }
}
