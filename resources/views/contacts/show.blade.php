@extends('layouts.app')
@section('title', $contact->first_name.' '.$contact->last_name)
@section('content')
<div class="py-2 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('contacts.index') }}" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ $contact->first_name }} {{ $contact->last_name }}</h2>
        <a href="{{ route('contacts.edit', $contact) }}" class="ml-auto inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-edit"></i> Edit</a>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-2xl">{{ strtoupper(substr($contact->first_name, 0, 1) . substr((string) ($contact->last_name ?? ''), 0, 1)) }}</div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $contact->first_name }} {{ $contact->last_name }}</h3>
                @if($contact->job_title)<p class="text-sm text-gray-500">{{ $contact->job_title }}</p>@endif
                @if($contact->customer)<p class="text-sm text-indigo-600"><a href="{{ route('customers.show', $contact->customer) }}">{{ $contact->customer->name }}</a></p>@endif
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            @if($contact->email)<div class="flex items-center gap-3 text-gray-600"><i class="fas fa-envelope w-4 text-gray-400"></i><a href="mailto:{{ $contact->email }}" class="hover:text-indigo-600">{{ $contact->email }}</a></div>@endif
            @if($contact->phone)<div class="flex items-center gap-3 text-gray-600"><i class="fas fa-phone w-4 text-gray-400"></i>{{ $contact->phone }}</div>@endif
            @if($contact->preferred_language)<div class="flex items-center gap-3 text-gray-600"><i class="fas fa-language w-4 text-gray-400"></i>{{ config('languages.supported.'.$contact->preferred_language.'.flag','') }} {{ config('languages.supported.'.$contact->preferred_language.'.native', $contact->preferred_language) }}</div>@endif
        </div>
        @if($contact->notes)<div class="mt-4 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600">{{ $contact->notes }}</p></div>@endif
    </div>
</div>
@endsection
