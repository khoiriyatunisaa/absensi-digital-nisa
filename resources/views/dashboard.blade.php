<x-app-layout>
    <x-slot name="eyebrow">Dashboard admin</x-slot>
    <x-slot name="header">Selamat datang, <span class="tone">{{ \Illuminate\Support\Str::of(Auth::user()->name)->explode(' ')->first() }}</span></x-slot>
    <x-slot name="subtitle">Ringkasan absensi dan status QR hari ini.</x-slot>
    <x-slot name="actions">
        <form method="POST" action="{{ route('admin.qr-tokens.generate') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                <x-icon name="refresh" /> Generate QR hari ini
            </button>
        </form>
    </x-slot>

    {{-- Statistik --}}
    <div class="stat-grid">
        <div class="stat stat-1">
            <span class="stat-icon"><x-icon name="users" /></span>
            <div class="stat-label">Total siswa</div>
            <div class="stat-value">{{ $totalStudents }}</div>
        </div>
        <div class="stat stat-2">
            <span class="stat-icon"><x-icon name="class" /></span>
            <div class="stat-label">Total kelas</div>
            <div class="stat-value">{{ $totalClasses }}</div>
        </div>
        <div class="stat stat-3">
            <span class="stat-icon"><x-icon name="pin" /></span>
            <div class="stat-label">Lokasi QR aktif</div>
            <div class="stat-value">{{ $activeLocations }}</div>
        </div>
        <div class="stat stat-4">
            <span class="stat-icon"><x-icon name="clipboard" /></span>
            <div class="stat-label">Hadir hari ini</div>
            <div class="stat-value">{{ $presentToday }} <small>/ {{ $totalStudents }} siswa</small></div>
            <div class="stat-note">{{ $presentRate }}% kehadiran</div>
        </div>
    </div>

    <div class="dash-grid">
        {{-- Grafik 7 hari --}}
        <section class="panel">
            <div class="panel-head">
                <h2 class="panel-title">Kehadiran 7 hari terakhir</h2>
                <span class="panel-note">Jumlah siswa yang absen per hari</span>
            </div>

            @php $max = max(1, $week->max('count')); @endphp
            <div class="week">
                @foreach ($week as $day)
                    <div class="week-col {{ $day['is_today'] ? 'is-today' : '' }} {{ $day['count'] > 0 ? 'has-data' : '' }}">
                        <span class="week-val">{{ $day['count'] }}</span>
                        <div class="week-bar" style="height: {{ $day['count'] > 0 ? max(8, round($day['count'] / $max * 78)) : 4 }}%"></div>
                        <div class="week-day">
                            {{ $day['date']->locale('id')->translatedFormat('D') }}<br>{{ $day['date']->format('d') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- QR hari ini --}}
        <section class="panel">
            <div class="panel-head">
                <h2 class="panel-title">QR hari ini</h2>
                <a href="{{ route('admin.qr-locations.index') }}" class="link">Kelola lokasi</a>
            </div>

            @if ($locations->isEmpty())
                <p class="panel-note" style="margin:0">Belum ada lokasi QR aktif. Tambahkan lokasi lebih dulu.</p>
            @else
                <ul class="loc-list">
                    @foreach ($locations as $location)
                        @php $token = $location->tokens->first(); @endphp
                        <li class="loc-item">
                            <span class="loc-icon"><x-icon name="qr" /></span>
                            <div>
                                <div class="loc-name">{{ $location->name }}</div>
                                <div class="loc-meta">{{ $location->code }} &middot; radius {{ $location->radius }} m</div>
                            </div>
                            <div class="loc-end">
                                @if ($token && $token->is_active)
                                    <a href="{{ route('admin.qr-tokens.display', $token) }}" target="_blank" class="link">Lihat QR</a>
                                @elseif ($token)
                                    <span class="badge badge-off">QR nonaktif</span>
                                @else
                                    <span class="badge badge-off">Belum dibuat</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

    {{-- Absensi terbaru --}}
    <section class="table-card">
        <div class="panel-head" style="padding:22px 24px 0;margin-bottom:14px">
            <h2 class="panel-title">Absensi terbaru</h2>
            <span class="panel-note">6 data terakhir</span>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Lokasi</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latest as $row)
                        <tr>
                            <td class="strong">{{ $row->student?->full_name ?? '-' }}</td>
                            <td>{{ $row->student?->classRoom?->class_name ?? '-' }}</td>
                            <td>{{ $row->qrLocation?->name ?? '-' }}</td>
                            <td class="mono">{{ $row->attendance_date->format('d/m/Y') }} {{ \Illuminate\Support\Str::limit((string) $row->attendance_time, 5, '') }}</td>
                            <td><span class="badge badge-ok">{{ ucfirst($row->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                <div class="empty-title">Belum ada absensi</div>
                                Data akan muncul di sini setelah siswa melakukan scan QR dari aplikasi mobile.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
