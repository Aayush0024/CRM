@extends('layouts.app')
@section('title', __('app.users.edit'))
@section('content')
<div class="py-2 max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.users.edit') }}: {{ $user->name }}</h2>
    </div>
    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.name') }}</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.email') }}</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.phone') }}</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.role') }}</label>
                    <select name="role_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.language') }}</label>
                    <select name="language_preference" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(config('languages.supported') as $code => $lang)
                        <option value="{{ $code }}" {{ old('language_preference', $user->language_preference) === $code ? 'selected' : '' }}>{{ $lang['flag'] }} {{ $lang['native'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.new_password') }} <span class="text-gray-400 text-xs">({{ __('app.users.leave_blank') }})</span></label><input type="password" name="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.users.confirm_password') }}</label><input type="password" name="password_confirmation" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600">
                    <label for="is_active" class="text-sm text-gray-700">{{ __('app.users.active') }}</label>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.update') }}</button>
            <a href="{{ route('users.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
