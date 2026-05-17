@extends('layouts.app')
@section('title', __('app.customers.title'))
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.customers.title') }}</h2>
        <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> {{ __('app.customers.add') }}
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('app.general.search_placeholder') }}"
                    class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('app.general.all') }} {{ __('app.customers.status') }}</option>
                @foreach(['active','inactive','prospect','churned'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ __('app.status.'.$s) }}</option>
                @endforeach
            </select>
            <select name="assigned_to" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('app.general.all') }} {{ __('app.customers.assigned_to') }}</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.filter') }}</button>
            <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition">{{ __('app.buttons.reset') }}</a>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.name') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.company') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.email') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.phone') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.status') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.language') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.customers.assigned_to') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('app.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <a href="{{ route('customers.show', $customer) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $customer->name }}</a>
                                    @if($customer->tags->count())
                                    <div class="flex gap-1 mt-0.5">
                                        @foreach($customer->tags->take(2) as $tag)
                                        <span class="text-xs bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $customer->company ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $customer->email ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $customer->status_color }}">{{ __('app.status.'.$customer->status) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">
                            @if($customer->preferred_language)
                            {{ config('languages.supported.'.$customer->preferred_language.'.flag','') }}
                            {{ config('languages.supported.'.$customer->preferred_language.'.native', $customer->preferred_language) }}
                            @else —
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $customer->assignedTo->name ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('customers.show', $customer) }}" class="text-gray-400 hover:text-indigo-600 transition" title="{{ __('app.buttons.view') }}"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('customers.edit', $customer) }}" class="text-gray-400 hover:text-yellow-500 transition" title="{{ __('app.buttons.edit') }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="{{ __('app.buttons.delete') }}"><i class="fas fa-trash"></i></button>
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
        @if($customers->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $customers->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
