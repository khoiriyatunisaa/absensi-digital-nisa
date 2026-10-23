<x-guest-layout>
    <h2>Selamat datang</h2>
    <p class="auth-sub">Masuk untuk mengelola absensi.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="nama@sekolah.test" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="field">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="auth-row">
            <label for="remember_me" class="check-row">
                <input id="remember_me" type="checkbox" class="check" name="remember">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <x-primary-button>Masuk</x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="auth-alt">Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar</a></p>
    @endif
</x-guest-layout>
