@extends('layouts.app')
@section('title', __('app.customers.add'))
@section('content')
<div class="py-2 max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('customers.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.customers.add') }}</h2>
    </div>
    <form action="{{ route('customers.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100">Basic Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.company') }}</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.mobile') }}</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.website') }}</label>
                    <input type="url" name="website" value="{{ old('website') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100">Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.address') }}</label>
                    <textarea name="address" rows="2" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.city') }}</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.state') }}</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.country') }}</label>
                    <input type="text" name="country" value="{{ old('country','India') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.pincode') }}</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100">Classification</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.status') }} <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['active','inactive','prospect','churned'] as $s)
                        <option value="{{ $s }}" {{ old('status','active') === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.industry') }}</label>
                    <input type="text" name="industry" value="{{ old('industry') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.source') }}</label>
                    <select name="source" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach(['website','referral','social_media','cold_call','email','event','other'] as $src)
                        <option value="{{ $src }}" {{ old('source') === $src ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$src)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.language') }}</label>
                    <select name="preferred_language" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($languages as $code => $lang)
                        <option value="{{ $code }}" {{ old('preferred_language') === $code ? 'selected' : '' }}>{{ $lang['flag'] }} {{ $lang['native'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.assigned_to') }}</label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.tags') }}</label>
                    <select name="tags[]" multiple class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 h-24">
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags',[])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.customers.notes') }}</label>
                    <textarea name="notes" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.save') }}</button>
            <a href="{{ route('customers.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
