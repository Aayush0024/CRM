@extends('layouts.auth')
@section('title', __('app.auth.login'))
@section('content')
<h2 class="text-xl font-bold text-gray-900 mb-6 text-center">{{ __('app.auth.login') }}</h2>
<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.email') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-400 @enderror"
                placeholder="you@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.auth.password') }}</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="••••••••">
        </div>
    </div>
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600">
            {{ __('app.auth.remember_me') }}
        </label>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
        {{ __('app.auth.login') }}
    </button>
</form>
<p class="text-center text-sm text-gray-500 mt-4">
    {{ __('app.auth.no_account') }}
    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">{{ __('app.buttons.register') }}</a>
</p>
@endsection
