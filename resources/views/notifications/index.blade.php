@extends('layouts.app')
@section('title', __('app.nav.notifications'))
@section('content')
<div class="py-2 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.nav.notifications') }}</h2>
        @if($notifications->where('read_at', null)->count())
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button class="text-sm text-indigo-600 hover:underline">Mark all as read</button>
        </form>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50">
        @forelse($notifications as $notif)
        @php
            $iconMap = [
                'info'    => ['icon' => 'fa-info-circle',      'bg' => 'bg-blue-100',   'text' => 'text-blue-500'],
                'success' => ['icon' => 'fa-check-circle',     'bg' => 'bg-green-100',  'text' => 'text-green-500'],
                'warning' => ['icon' => 'fa-exclamation-circle','bg' => 'bg-yellow-100','text' => 'text-yellow-500'],
                'danger'  => ['icon' => 'fa-times-circle',     'bg' => 'bg-red-100',    'text' => 'text-red-500'],
            ];
            $style = $iconMap[$notif->type] ?? $iconMap['info'];
        @endphp

        <div class="flex items-start gap-4 p-4 {{ is_null($notif->read_at) ? 'bg-indigo-50/30' : '' }} hover:bg-gray-50 transition">
            {{-- Icon --}}
            <div class="w-9 h-9 rounded-full {{ $style['bg'] }} flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas {{ $style['icon'] }} {{ $style['text'] }} text-sm"></i>
            </div>

            {{-- Body --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-semibold {{ $style['text'] }} uppercase tracking-wide">{{ $notif->title }}</span>
                    @if(is_null($notif->read_at))
                        <span class="w-2 h-2 rounded-full bg-indigo-500 inline-block"></span>
                    @endif
                </div>
                @if($notif->link)
                    <a href="{{ $notif->link }}" class="text-sm text-gray-800 hover:text-indigo-600 hover:underline leading-snug block">
                        {{ $notif->message }}
                    </a>
                @else
                    <p class="text-sm text-gray-800 leading-snug">{{ $notif->message }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-1">
                    {{ $notif->created_at->format('d M Y, H:i') }}
                    &bull; {{ $notif->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                @if(is_null($notif->read_at))
                <form action="{{ route('notifications.read', $notif) }}" method="POST">
                    @csrf
                    <button class="text-xs text-indigo-600 hover:underline whitespace-nowrap" title="Mark as read">
                        Mark read
                    </button>
                </form>
                @endif
                <form action="{{ route('notifications.destroy', $notif) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-gray-300 hover:text-red-500 text-sm" title="Delete">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <i class="fas fa-bell-slash text-3xl text-gray-200 mb-3 block"></i>
            <p class="text-gray-400 text-sm">No notifications yet</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-4">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
