<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Regional CRM') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>body { font-family: 'Inter', 'Noto Sans Devanagari', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-handshake text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ config('app.name', 'Regional CRM') }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ __('app.general.crm_tagline') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif
            @yield('content')
        </div>

        {{-- Language switcher --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            @foreach(config('languages.supported') as $code => $lang)
            <a href="{{ route('lang.switch', $code) }}" class="text-xs px-2 py-1 rounded-full {{ app()->getLocale() === $code ? 'bg-indigo-600 text-white' : 'bg-white text-gray-500 hover:bg-indigo-50 border border-gray-200' }} transition">
                {{ $lang['flag'] }} {{ $lang['native'] }}
            </a>
            @endforeach
        </div>
    </div>
</body>
</html>
