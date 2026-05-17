@extends('layouts.app')
@section('title', 'Edit Contact')
@section('content')
<div class="py-2 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('contacts.show', $contact) }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">Edit Contact: {{ $contact->first_name }} {{ $contact->last_name }}</h2>
    </div>
    <form action="{{ route('contacts.update', $contact) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label><input type="text" name="first_name" value="{{ old('first_name', $contact->first_name) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label><input type="text" name="last_name" value="{{ old('last_name', $contact->last_name) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $contact->email) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Position</label><input type="text" name="job_title" value="{{ old('job_title', $contact->job_title) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                    <select name="customer_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $contact->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Language</label>
                    <select name="preferred_language" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($languages as $code => $lang)
                        <option value="{{ $code }}" {{ old('preferred_language', $contact->preferred_language) === $code ? 'selected' : '' }}>{{ $lang['flag'] }} {{ $lang['native'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Notes</label><textarea name="notes" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes', $contact->notes) }}</textarea></div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.update') }}</button>
            <a href="{{ route('contacts.show', $contact) }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
