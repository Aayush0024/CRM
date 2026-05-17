@extends('layouts.app')
@section('title', $deal->title)
@section('content')
<div class="py-2">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('deals.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-gray-900">{{ $deal->title }}</h2>
            <span class="text-xs px-2 py-0.5 rounded-full badge-{{ $deal->stage_color }}">{{ __('app.stages.'.$deal->stage) }}</span>
        </div>
        <a href="{{ route('deals.edit', $deal) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-edit"></i> {{ __('app.buttons.edit') }}</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-green-600 mb-1">₹{{ number_format($deal->value) }}</div>
                <div class="text-sm text-gray-500 mb-4">{{ __('app.deals.value') }}</div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">{{ __('app.deals.probability') }}</span><span class="font-medium">{{ $deal->probability }}%</span></div>
                    @if($deal->customer)<div class="flex justify-between"><span class="text-gray-500">{{ __('app.general.customer') }}</span><a href="{{ route('customers.show', $deal->customer) }}" class="text-indigo-600 hover:underline">{{ $deal->customer->name }}</a></div>@endif
                    @if($deal->expected_close_date)<div class="flex justify-between"><span class="text-gray-500">{{ __('app.deals.close_date') }}</span><span>{{ $deal->expected_close_date->format('d M Y') }}</span></div>@endif
                    @if($deal->assignedTo)<div class="flex justify-between"><span class="text-gray-500">{{ __('app.deals.assigned_to') }}</span><span>{{ $deal->assignedTo->name }}</span></div>@endif
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-4">
            @if($deal->description)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-3">{{ __('app.general.description') }}</h3>
                <p class="text-sm text-gray-600">{{ $deal->description }}</p>
            </div>
            @endif
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.general.notes') }}</h3>
                <form action="{{ route('notes.store') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="notable_type" value="App\Models\Deal">
                    <input type="hidden" name="notable_id" value="{{ $deal->id }}">
                    <div class="flex gap-2">
                        <input type="text" name="content" placeholder="{{ __('app.general.add_note') }}..." required class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.add') }}</button>
                    </div>
                </form>
                @forelse($deal->notes as $note)
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
