<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($header) ? strip_tags((string) $header) . ' · ' : '' }}{{ config('app.name', 'Absensi Digital') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/matcha.css') }}?v={{ filemtime(public_path('css/matcha.css')) }}">
    </head>
    <body>
        <div class="shell" x-data="{ nav: false }" @keydown.escape.window="nav = false">
            <div class="scrim" x-show="nav" x-cloak x-transition.opacity @click="nav = false"></div>

            @include('layouts.navigation')

            <div class="main">
                <header class="topbar">
                    <button type="button" class="icon-btn menu-btn" @click="nav = !nav" aria-label="Buka menu">
                        <x-icon name="menu" />
                    </button>

                    <div class="topbar-date">
                        <x-icon name="calendar" />
                        <span>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="profile-chip">
                        <span class="avatar">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                        {{ Auth::user()->name }}
                    </a>
                </header>

                <main class="content">
                    @if (isset($header))
                        <div class="page-head">
                            <div>
                                @isset($eyebrow)<div class="page-eyebrow">{{ $eyebrow }}</div>@endisset
                                <h1 class="page-title">{{ $header }}</h1>
                                @isset($subtitle)<p class="page-subtitle">{{ $subtitle }}</p>@endisset
                            </div>
                            @isset($actions)<div class="page-actions">{{ $actions }}</div>@endisset
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="status">
                            <x-icon name="check" />
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>

                <footer class="footer">{{ config('app.name') }} &middot; {{ date('Y') }}</footer>
            </div>
        </div>
    </body>
</html>
