@extends('layouts.app')
@section('title', __('app.deals.edit'))
@section('content')
<div class="py-2 max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('deals.show', $deal) }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.deals.edit') }}: {{ $deal->title }}</h2>
    </div>
    <form action="{{ route('deals.update', $deal) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.title_field') }} <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $deal->title) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.value') }}</label><input type="number" name="value" value="{{ old('value', $deal->value) }}" step="0.01" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.stage') }}</label>
                    <select name="stage" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['prospecting','qualification','proposal','negotiation','closed_won','closed_lost'] as $s)
                        <option value="{{ $s }}" {{ old('stage', $deal->stage) === $s ? 'selected' : '' }}>{{ __('app.stages.'.$s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.probability') }}</label><input type="number" name="probability" value="{{ old('probability', $deal->probability) }}" min="0" max="100" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.close_date') }}</label><input type="date" name="expected_close_date" value="{{ old('expected_close_date', $deal->expected_close_date?->format('Y-m-d')) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.general.customer') }}</label>
                    <select name="customer_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $deal->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.assigned_to') }}</label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $deal->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.description') }}</label><textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $deal->description) }}</textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.deals.lost_reason') }}</label><input type="text" name="lost_reason" value="{{ old('lost_reason', $deal->lost_reason) }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.update') }}</button>
            <a href="{{ route('deals.show', $deal) }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
