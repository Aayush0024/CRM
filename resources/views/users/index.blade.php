@extends('layouts.app')
@section('title', __('app.users.title'))
@section('content')
<div class="py-2">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.users.title') }}</h2>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> {{ __('app.users.add') }}
        </a>
    </div>

    {{-- Role legend --}}
    <div class="flex flex-wrap gap-2 mb-4">
        <span class="text-xs text-gray-500 font-medium self-center">Roles:</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-red font-medium">Admin — Full access</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-blue font-medium">Sales Manager — Team leads, assign deals, team reports</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-indigo font-medium">Sales Executive — Own leads, own deals, own tasks</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-purple font-medium">Support Agent — Customer issues, notes &amp; tasks</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-5 py-3 font-medium">{{ __('app.users.name') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('app.users.email') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('app.users.role') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('app.users.language') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('app.users.status') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('app.general.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 {{ !$user->is_active ? 'opacity-60' : '' }}">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                            <div>
                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="ml-1 text-xs text-indigo-500">(you)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $roleColors = [
                                'admin'           => 'badge-red',
                                'sales_manager'   => 'badge-blue',
                                'manager'         => 'badge-blue',
                                'sales_executive' => 'badge-indigo',
                                'agent'           => 'badge-indigo',
                                'support_agent'   => 'badge-purple',
                            ];
                            $roleName = $user->role->name ?? '';
                            $roleColor = $roleColors[$roleName] ?? 'badge-gray';
                        @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $roleColor }}">
                            {{ $user->role->display_name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">
                        {{ config('languages.supported.'.$user->language_preference.'.flag','') }}
                        {{ config('languages.supported.'.$user->language_preference.'.native', $user->language_preference ?? 'en') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $user->is_active ? 'badge-green' : 'badge-gray' }}">
                            {{ $user->is_active ? __('app.users.active') : __('app.users.inactive') }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-gray-400 hover:text-yellow-500" title="Edit user">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Reset Password --}}
                            <a href="{{ route('users.reset-password', $user) }}"
                               class="text-gray-400 hover:text-indigo-500" title="Reset password">
                                <i class="fas fa-key"></i>
                            </a>

                            @if($user->id !== auth()->id())
                                {{-- Toggle Active/Disable --}}
                                <form action="{{ route('users.toggle-active', $user) }}" method="POST"
                                      onsubmit="return confirm('{{ $user->is_active ? 'Disable this account?' : 'Enable this account?' }}')">
                                    @csrf
                                    <button type="submit"
                                            class="text-gray-400 {{ $user->is_active ? 'hover:text-orange-500' : 'hover:text-green-500' }}"
                                            title="{{ $user->is_active ? 'Disable account' : 'Enable account' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500" title="Delete user">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400">{{ __('app.general.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
