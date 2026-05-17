@extends('layouts.app')
@section('title', __('app.tasks.title'))
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.tasks.title') }}</h2>
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> {{ __('app.tasks.add') }}
        </a>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('app.general.search_placeholder') }}" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                @foreach(['pending','in_progress','completed','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                @endforeach
            </select>
            <select name="priority" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Priority</option>
                @foreach(['low','medium','high','urgent'] as $p)
                <option value="{{ $p }}" {{ request('priority') === $p ? 'selected' : '' }}>{{ __('app.priority.'.$p) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.filter') }}</button>
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition">{{ __('app.buttons.reset') }}</a>
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium w-8"></th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.title_field') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.type') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.status') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.priority') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.due_date') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.tasks.assigned_to') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 transition {{ $task->isOverdue() ? 'bg-red-50/30' : '' }}">
                        <td class="px-5 py-3.5">
                            <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-5 h-5 rounded-full border-2 {{ $task->status === 'completed' ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-indigo-500' }} flex items-center justify-center transition">
                                    @if($task->status === 'completed')<i class="fas fa-check text-white text-xs"></i>@endif
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</span>
                            @if($task->isOverdue())<span class="ml-2 text-xs text-red-500"><i class="fas fa-exclamation-circle"></i> {{ __('app.general.overdue') }}</span>@endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">{{ __('app.task_types.'.$task->type) }}</td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $task->status_color }}">{{ __('app.status.'.$task->status) }}</span></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $task->priority_color }}">{{ __('app.priority.'.$task->priority) }}</span></td>
                        <td class="px-5 py-3.5 text-gray-500 {{ $task->isOverdue() ? 'text-red-500 font-medium' : '' }}">{{ $task->due_date?->format('d M Y, H:i') ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $task->assignedTo->name ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex gap-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">@csrf @method('DELETE')<button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400">{{ __('app.general.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $tasks->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
