@extends('layouts.app')
@section('title', __('app.leads.title'))
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.leads.title') }}</h2>
        <a href="{{ route('leads.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> {{ __('app.leads.add') }}
        </a>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('app.general.search_placeholder') }}" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('app.general.all') }} Status</option>
                @foreach(['new','contacted','qualified','unqualified','converted','lost'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                @endforeach
            </select>
            <select name="priority" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('app.general.all') }} Priority</option>
                @foreach(['low','medium','high'] as $p)
                <option value="{{ $p }}" {{ request('priority') === $p ? 'selected' : '' }}>{{ __('app.priority.'.$p) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.filter') }}</button>
            <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition">{{ __('app.buttons.reset') }}</a>
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.title_field') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.name') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.company') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.status') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.priority') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.value') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.leads.assigned_to') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5">
                            <a href="{{ route('leads.show', $lead) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $lead->title }}</a>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $lead->name }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $lead->company ?? '—' }}</td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $lead->status_color }}">{{ __('app.status.'.$lead->status) }}</span></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $lead->priority_color }}">{{ __('app.priority.'.$lead->priority) }}</span></td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">{{ $lead->estimated_value ? '₹'.number_format($lead->estimated_value) : '—' }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $lead->assignedTo->name ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('leads.show', $lead) }}" class="text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('leads.edit', $lead) }}" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                @if($lead->status !== 'converted')
                                <form action="{{ route('leads.convert', $lead) }}" method="POST" onsubmit="return confirm('Convert this lead to a deal?')">
                                    @csrf
                                    <button class="text-gray-400 hover:text-green-500" title="Convert to Deal"><i class="fas fa-exchange-alt"></i></button>
                                </form>
                                @endif
                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400">{{ __('app.general.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $leads->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
