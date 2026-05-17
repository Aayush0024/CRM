@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="py-2 max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">Change Password</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        {{-- User info banner --}}
        <div class="flex items-center gap-3 mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
            <img src="{{ auth()->user()->avatar_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }} &bull; {{ auth()->user()->role->display_name ?? 'User' }}</p>
            </div>
        </div>

        <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('current_password') border-red-400 @enderror"
                    placeholder="Enter your current password">
                @error('current_password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required minlength="8"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('password') border-red-400 @enderror"
                    placeholder="Minimum 8 characters">
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required minlength="8"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                    placeholder="Repeat the new password">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
                    <i class="fas fa-lock mr-1"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
