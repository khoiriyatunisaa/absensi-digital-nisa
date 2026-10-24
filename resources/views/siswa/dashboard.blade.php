<x-app-layout>
    <x-slot name="eyebrow">Dashboard siswa</x-slot>
    <x-slot name="header">Halo, <span class="tone">{{ \Illuminate\Support\Str::of(Auth::user()->name)->explode(' ')->first() }}</span></x-slot>
    <x-slot name="subtitle">Absensi dilakukan lewat aplikasi mobile dengan scan QR di lokasi sekolah.</x-slot>

    @if (! $student)
        <div class="alert alert-error" role="alert">
            <x-icon name="shield" />
            <span>Akunmu belum terhubung dengan data siswa. Hubungi admin sekolah.</span>
        </div>
    @else
        {{-- Status hari ini --}}
        <section class="status-hero {{ $todayAttendance ? 'is-done' : '' }}">
            <x-flower class="flower status-flower" />
            <div style="position:relative">
                <div class="status-eyebrow">Status hari ini &middot; {{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
                <div class="status-title">{{ $todayAttendance ? 'Sudah absen' : 'Belum absen' }}</div>
                <p class="status-desc">
                    @if ($todayAttendance)
                        Tercatat pukul {{ \Illuminate\Support\Str::limit((string) $todayAttendance->attendance_time, 5, '') }}
                        @if ($todayAttendance->qrLocation) di {{ $todayAttendance->qrLocation->name }}@endif.
                    @else
                        Buka aplikasi mobile Absensi Digital, lalu scan QR di lokasi sekolah.
                    @endif
                </p>
            </div>
        </section>

        <div class="stat-grid stat-grid-3">
            <div class="stat stat-1">
                <span class="stat-icon"><x-icon name="user" /></span>
                <div class="stat-label">NIS</div>
                <div class="stat-value" style="font-size:28px">{{ $student->nis }}</div>
            </div>
            <div class="stat stat-2">
                <span class="stat-icon"><x-icon name="class" /></span>
                <div class="stat-label">Kelas</div>
                <div class="stat-value" style="font-size:28px">{{ $student->classRoom?->class_name ?? '-' }}</div>
                <div class="stat-note">{{ $student->classRoom?->major }}</div>
            </div>
            <div class="stat stat-4">
                <span class="stat-icon"><x-icon name="clipboard" /></span>
                <div class="stat-label">Hadir bulan ini</div>
                <div class="stat-value">{{ $monthPresent }} <small>hari</small></div>
                <div class="stat-note">{{ now()->locale('id')->translatedFormat('F Y') }}</div>
            </div>
        </div>
    @endif

    <div class="dash-grid dash-grid-even">
        {{-- Cara absen --}}
        <section class="panel">
            <div class="panel-head">
                <h2 class="panel-title">Cara absen</h2>
            </div>
            <ol class="steps">
                <li>
                    <span class="step-num">1</span>
                    <div><strong>Login di aplikasi mobile</strong><div class="loc-meta">Gunakan email dan password akun ini.</div></div>
                </li>
                <li>
                    <span class="step-num">2</span>
                    <div><strong>Aktifkan GPS</strong><div class="loc-meta">Datang ke salah satu lokasi absensi di samping.</div></div>
                </li>
                <li>
                    <span class="step-num">3</span>
                    <div><strong>Scan QR di lokasi</strong><div class="loc-meta">Server memeriksa QR dan jarakmu dari titik absensi.</div></div>
                </li>
            </ol>
        </section>

        {{-- Lokasi hari ini --}}
        <section class="panel">
            <div class="panel-head">
                <h2 class="panel-title">Lokasi absensi hari ini</h2>
            </div>

            @if ($locations->isEmpty())
                <p class="panel-note" style="margin:0">Belum ada lokasi absensi aktif.</p>
            @else
                <ul class="loc-list">
                    @foreach ($locations as $location)
                        @php $ready = $location->tokens->contains('is_active', true); @endphp
                        <li class="loc-item">
                            <span class="loc-icon"><x-icon name="pin" /></span>
                            <div>
                                <div class="loc-name">{{ $location->name }}</div>
                                <div class="loc-meta">{{ $location->code }} &middot; radius {{ $location->radius }} m</div>
                            </div>
                            <div class="loc-end">
                                @if ($ready)
                                    <span class="badge badge-ok">QR tersedia</span>
                                @else
                                    <span class="badge badge-off">QR belum tersedia</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

    {{-- Keamanan akun --}}
    <div class="tip" style="margin-bottom:18px">
        <x-icon name="shield" />
        <div>
            <strong>Ganti password awalmu.</strong>
            Password awal akun sama dengan NIS, jadi mudah ditebak.
            <a href="{{ route('profile.edit') }}" class="link">Ganti di menu Profil</a>
        </div>
    </div>

    {{-- Riwayat --}}
    <section class="table-card">
        <div class="panel-head" style="padding:22px 24px 0;margin-bottom:14px">
            <h2 class="panel-title">Riwayat absensi</h2>
            <span class="panel-note">10 data terakhir</span>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Tanggal</th><th>Jam</th><th>Lokasi</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($history as $row)
                        <tr>
                            <td class="strong">{{ $row->attendance_date->format('d/m/Y') }}</td>
                            <td class="mono">{{ \Illuminate\Support\Str::limit((string) $row->attendance_time, 5, '') }}</td>
                            <td>{{ $row->qrLocation?->name ?? '-' }}</td>
                            <td><span class="badge badge-ok">{{ ucfirst($row->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">
                                <div class="empty-title">Belum ada riwayat</div>
                                Riwayat muncul setelah absensi tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
