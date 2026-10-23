@php
    $user = Auth::user();
    $initial = strtoupper(mb_substr($user->name, 0, 1));
    $links = $user->role === 'admin'
        ? [
            ['route' => 'dashboard',                'match' => 'dashboard',           'icon' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => 'admin.classes.index',      'match' => 'admin.classes.*',     'icon' => 'class',     'label' => 'Data Kelas'],
            ['route' => 'admin.students.index',     'match' => 'admin.students.*',    'icon' => 'users',     'label' => 'Data Siswa'],
            ['route' => 'admin.qr-locations.index', 'match' => 'admin.qr-locations.*','icon' => 'pin',       'label' => 'Lokasi QR'],
        ]
        : [
            ['route' => 'siswa.dashboard',          'match' => 'siswa.dashboard',     'icon' => 'dashboard', 'label' => 'Dashboard'],
        ];
@endphp

<aside class="sidebar" :class="{ 'is-open': nav }" aria-label="Navigasi utama">
    <a href="{{ route('dashboard') }}" class="brand">
        <span class="brand-mark"><x-icon name="leaf" /></span>
        <span>
            <span class="brand-name" style="display:block">Absensi Digital</span>
            <span class="brand-sub" style="display:block">QR &middot; Token &middot; Lokasi</span>
        </span>
    </a>

    <div class="side-label">Menu</div>
    <nav class="side-nav">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}"
               class="side-link {{ request()->routeIs($link['match']) ? 'is-active' : '' }}"
               @if (request()->routeIs($link['match'])) aria-current="page" @endif>
                <x-icon :name="$link['icon']" />
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="side-user">
        <span class="avatar">{{ $initial }}</span>
        <div class="side-user-info">
            <div class="side-user-name">{{ $user->name }}</div>
            <div class="side-user-role">{{ $user->role === 'admin' ? 'Administrator' : ucfirst($user->role) }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="icon-btn" title="Keluar" aria-label="Keluar">
                <x-icon name="logout" />
            </button>
        </form>
    </div>
</aside>
