@extends('layouts.app')
@section('title', $lead->title)
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('leads.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $lead->title }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs px-2 py-0.5 rounded-full badge-{{ $lead->status_color }}">{{ __('app.status.'.$lead->status) }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full badge-{{ $lead->priority_color }}">{{ __('app.priority.'.$lead->priority) }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            @if($lead->status !== 'converted')
            <form action="{{ route('leads.convert', $lead) }}" method="POST" onsubmit="return confirm('Convert this lead to a deal?')">
                @csrf
                <button class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    <i class="fas fa-exchange-alt"></i> {{ __('app.leads.convert') }}
                </button>
            </form>
            @endif
            <a href="{{ route('leads.edit', $lead) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
                <i class="fas fa-edit"></i> {{ __('app.buttons.edit') }}
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">Lead Details</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Contact</span><span class="font-medium">{{ $lead->name }}</span></div>
                    @if($lead->email)<div class="flex justify-between"><span class="text-gray-500">Email</span><span>{{ $lead->email }}</span></div>@endif
                    @if($lead->phone)<div class="flex justify-between"><span class="text-gray-500">Phone</span><span>{{ $lead->phone }}</span></div>@endif
                    @if($lead->company)<div class="flex justify-between"><span class="text-gray-500">Company</span><span>{{ $lead->company }}</span></div>@endif
                    @if($lead->estimated_value)<div class="flex justify-between"><span class="text-gray-500">Value</span><span class="font-semibold text-green-600">₹{{ number_format($lead->estimated_value) }}</span></div>@endif
                    @if($lead->source)<div class="flex justify-between"><span class="text-gray-500">Source</span><span>{{ ucwords(str_replace('_',' ',$lead->source)) }}</span></div>@endif
                    @if($lead->expected_close_date)<div class="flex justify-between"><span class="text-gray-500">Close Date</span><span>{{ $lead->expected_close_date->format('d M Y') }}</span></div>@endif
                    @if($lead->assignedTo)<div class="flex justify-between"><span class="text-gray-500">Assigned To</span><span>{{ $lead->assignedTo->name }}</span></div>@endif
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-4">
            @if($lead->description)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-3">Description</h3>
                <p class="text-sm text-gray-600">{{ $lead->description }}</p>
            </div>
            @endif
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.general.notes') }}</h3>
                <form action="{{ route('notes.store') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="notable_type" value="App\Models\Lead">
                    <input type="hidden" name="notable_id" value="{{ $lead->id }}">
                    <div class="flex gap-2">
                        <input type="text" name="content" placeholder="{{ __('app.general.add_note') }}..." required class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.add') }}</button>
                    </div>
                </form>
                @forelse($lead->notes as $note)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 mb-2">
                    <div class="flex-1"><p class="text-sm text-gray-700">{{ $note->content }}</p><p class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p></div>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST">@csrf @method('DELETE')<button class="text-gray-400 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button></form>
                </div>
                @empty<p class="text-sm text-gray-400 text-center py-3">No notes yet</p>@endforelse
            </div>
        </div>
    </div>
</div>
@endsection
