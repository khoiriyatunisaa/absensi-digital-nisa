<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Absensi Digital') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/matcha.css') }}?v={{ filemtime(public_path('css/matcha.css')) }}">
    </head>
    <body>
        <div class="landing">
            <nav class="landing-nav">
                <a href="/" class="brand">
                    <span class="brand-mark"><x-icon name="leaf" /></span>
                    <span>
                        <span class="brand-name" style="display:block">{{ config('app.name') }}</span>
                    </span>
                </a>

                <div class="page-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                        @endif
                    @endauth
                </div>
            </nav>

            <main class="landing-hero">
                <div>
                    <h1 class="hero-title">Absensi <span class="tone">Digital</span></h1>
                    <div class="hero-eyebrow">QR &middot; Token &middot; Lokasi</div>
                    <p class="hero-lead">Presensi sekolah berbasis QR dinamis. Setiap lokasi punya token sendiri yang berganti setiap hari, jadi foto QR lama tidak bisa dipakai lagi.</p>

                    <div class="hero-cta">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Buka dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Masuk sekarang</a>
                        @endauth
                    </div>

                    <div class="swatches" aria-hidden="true">
                        <x-flower style="color:#F1F4E7;filter:drop-shadow(0 0 0 1px #DCE2CD)" />
                        <x-flower style="color:#D8E2C7" />
                        <x-flower style="color:#A7B892" />
                        <x-flower style="color:#6B7F5B" />
                        <x-flower style="color:#47563F" />
                        <x-flower style="color:#CBBF9E" />
                        <x-flower style="color:#E3DCC7" />
                    </div>

                    <div class="feature-row">
                        <div class="feature">
                            <span class="loc-icon"><x-icon name="qr" /></span>
                            <h3>QR harian</h3>
                            <p>Token acak 64 karakter dibuat per lokasi setiap hari dan tidak bisa ditebak.</p>
                        </div>
                        <div class="feature">
                            <span class="loc-icon"><x-icon name="shield" /></span>
                            <h3>Divalidasi server</h3>
                            <p>Token, tanggal, masa berlaku, dan status diperiksa server, bukan aplikasi.</p>
                        </div>
                        <div class="feature">
                            <span class="loc-icon"><x-icon name="dashboard" /></span>
                            <h3>Dashboard admin</h3>
                            <p>Kelola kelas, siswa, dan lokasi QR, lalu pantau kehadiran dalam satu tempat.</p>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="landing-foot">{{ config('app.name') }} &middot; {{ date('Y') }}</footer>
        </div>
    </body>
</html>
