@extends('layouts.app')
@section('title', __('app.leads.edit'))
@section('content')
<div class="py-2 max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('leads.show', $lead) }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.leads.edit') }}: {{ $lead->title }}</h2>
    </div>
    <form action="{{ route('leads.update', $lead) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.title_field') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $lead->title) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.name') }}</label><input type="text" name="name" value="{{ old('name', $lead->name) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.email') }}</label><input type="email" name="email" value="{{ old('email', $lead->email) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.phone') }}</label><input type="text" name="phone" value="{{ old('phone', $lead->phone) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.company') }}</label><input type="text" name="company" value="{{ old('company', $lead->company) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.status') }}</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['new','contacted','qualified','unqualified','converted','lost'] as $s)
                        <option value="{{ $s }}" {{ old('status', $lead->status) === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.priority') }}</label>
                    <select name="priority" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['low','medium','high'] as $p)
                        <option value="{{ $p }}" {{ old('priority', $lead->priority) === $p ? 'selected' : '' }}>{{ __('app.priority.'.$p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.value') }}</label><input type="number" name="estimated_value" value="{{ old('estimated_value', $lead->estimated_value) }}" step="0.01" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.close_date') }}</label><input type="date" name="expected_close_date" value="{{ old('expected_close_date', $lead->expected_close_date?->format('Y-m-d')) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.assigned_to') }}</label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.leads.description') }}</label><textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $lead->description) }}</textarea></div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.update') }}</button>
            <a href="{{ route('leads.show', $lead) }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
