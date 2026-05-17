@extends('layouts.app')
@section('title', __('app.tasks.add'))
@section('content')
<div class="py-2 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('tasks.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.tasks.add') }}</h2>
    </div>
    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.title_field') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.type') }}</label>
                    <select name="type" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['call','email','meeting','follow_up','demo','other'] as $t)
                        <option value="{{ $t }}" {{ old('type','call') === $t ? 'selected' : '' }}>{{ __('app.task_types.'.$t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.priority') }}</label>
                    <select name="priority" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['low','medium','high','urgent'] as $p)
                        <option value="{{ $p }}" {{ old('priority','medium') === $p ? 'selected' : '' }}>{{ __('app.priority.'.$p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.status') }}</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['pending','in_progress'] as $s)
                        <option value="{{ $s }}" {{ old('status','pending') === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.due_date') }}</label>
                    <input type="datetime-local" name="due_date" value="{{ old('due_date') }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.assigned_to') }}</label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('app.general.select') }}</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.tasks.description') }}</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">{{ __('app.buttons.save') }}</button>
            <a href="{{ route('tasks.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">{{ __('app.buttons.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
