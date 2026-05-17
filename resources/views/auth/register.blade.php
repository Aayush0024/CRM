@extends('layouts.auth')
@section('title', __('app.auth.register'))
@section('content')
<h2 class="text-xl font-bold text-gray-900 mb-6 text-center">{{ __('app.auth.register') }}</h2>
<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.name') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-user text-sm"></i></span>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Your full name">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.email') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="you@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.password') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Min 8 characters">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.confirm_password') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password_confirmation" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Repeat password">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.settings.user_language') }}</label>
        <select name="language_preference" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach(config('languages.supported') as $code => $lang)
            <option value="{{ $code }}" {{ old('language_preference','en') === $code ? 'selected' : '' }}>
                {{ $lang['flag'] }} {{ $lang['native'] }} ({{ $lang['name'] }})
            </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
        {{ __('app.auth.register') }}
    </button>
</form>
<p class="text-center text-sm text-gray-500 mt-4">
    {{ __('app.auth.have_account') }}
    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">{{ __('app.auth.login') }}</a>
</p>
@endsection
