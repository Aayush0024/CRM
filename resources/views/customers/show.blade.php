@extends('layouts.app')
@section('title', $customer->name)
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('customers.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                <p class="text-sm text-gray-500">{{ $customer->company }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
                <i class="fas fa-edit"></i> {{ __('app.buttons.edit') }}
            </a>
            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">
                @csrf @method('DELETE')
                <button class="inline-flex items-center gap-2 bg-red-50 border border-red-200 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                    <i class="fas fa-trash"></i> {{ __('app.buttons.delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Left: Details --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $customer->name }}</h3>
                        <span class="text-xs px-2 py-0.5 rounded-full badge-{{ $customer->status_color }}">{{ __('app.status.'.$customer->status) }}</span>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    @if($customer->email)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-envelope w-4 text-gray-400"></i> <a href="mailto:{{ $customer->email }}" class="hover:text-indigo-600">{{ $customer->email }}</a></div>
                    @endif
                    @if($customer->phone)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-phone w-4 text-gray-400"></i> {{ $customer->phone }}</div>
                    @endif
                    @if($customer->mobile)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-mobile-alt w-4 text-gray-400"></i> {{ $customer->mobile }}</div>
                    @endif
                    @if($customer->website)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-globe w-4 text-gray-400"></i> <a href="{{ $customer->website }}" target="_blank" class="hover:text-indigo-600 truncate">{{ $customer->website }}</a></div>
                    @endif
                    @if($customer->city || $customer->state)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-map-marker-alt w-4 text-gray-400"></i> {{ implode(', ', array_filter([$customer->city, $customer->state, $customer->country])) }}</div>
                    @endif
                    @if($customer->industry)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-industry w-4 text-gray-400"></i> {{ $customer->industry }}</div>
                    @endif
                    @if($customer->preferred_language)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-language w-4 text-gray-400"></i>
                        {{ config('languages.supported.'.$customer->preferred_language.'.flag','') }}
                        {{ config('languages.supported.'.$customer->preferred_language.'.native', $customer->preferred_language) }}
                    </div>
                    @endif
                    @if($customer->assignedTo)
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-user w-4 text-gray-400"></i> {{ $customer->assignedTo->name }}</div>
                    @endif
                </div>
                @if($customer->tags->count())
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($customer->tags as $tag)
                        <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="grid grid-cols-2 gap-3">
                    <div class="text-center p-3 bg-blue-50 rounded-xl">
                        <div class="text-xl font-bold text-blue-600">{{ $customer->contacts->count() }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('app.customers.contacts') }}</div>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-xl">
                        <div class="text-xl font-bold text-yellow-600">{{ $customer->leads->count() }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('app.customers.leads') }}</div>
                    </div>
                    <div class="text-center p-3 bg-indigo-50 rounded-xl">
                        <div class="text-xl font-bold text-indigo-600">{{ $customer->deals->count() }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('app.customers.deals') }}</div>
                    </div>
                    <div class="text-center p-3 bg-orange-50 rounded-xl">
                        <div class="text-xl font-bold text-orange-600">{{ $customer->tasks->count() }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('app.customers.tasks') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Tabs --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Notes --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.general.notes') }}</h3>
                <form action="{{ route('notes.store') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="notable_type" value="App\Models\Customer">
                    <input type="hidden" name="notable_id" value="{{ $customer->id }}">
                    <div class="flex gap-2">
                        <input type="text" name="content" placeholder="{{ __('app.general.add_note') }}..." required
                            class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">{{ __('app.buttons.add') }}</button>
                    </div>
                </form>
                <div class="space-y-3">
                    @forelse($customer->noteRecords->sortByDesc('is_pinned') as $note)
                    <div class="flex items-start gap-3 p-3 rounded-xl {{ $note->is_pinned ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }}">
                        @if($note->is_pinned)<i class="fas fa-thumbtack text-yellow-500 mt-0.5 text-xs"></i>@endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700">{{ $note->content }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $note->createdBy->name ?? '' }} · {{ $note->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('notes.pin', $note) }}" method="POST">@csrf @method('PATCH')
                                <button class="text-gray-400 hover:text-yellow-500 text-xs"><i class="fas fa-thumbtack"></i></button>
                            </form>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST">@csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-3">No notes yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Activities --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.general.activities') }}</h3>
                <div class="space-y-3">
                    @forelse($customer->activities->take(10) as $activity)
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-circle text-indigo-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700">{{ $activity->description }}</p>
                            <p class="text-xs text-gray-400">{{ $activity->causer->name ?? 'System' }} · {{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-3">No activities yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Deals --}}
            @if($customer->deals->count())
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.customers.deals') }}</h3>
                <div class="space-y-2">
                    @foreach($customer->deals as $deal)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div>
                            <a href="{{ route('deals.show', $deal) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $deal->title }}</a>
                            <p class="text-xs text-gray-400">{{ __('app.stages.'.$deal->stage) }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">₹{{ number_format($deal->value) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
