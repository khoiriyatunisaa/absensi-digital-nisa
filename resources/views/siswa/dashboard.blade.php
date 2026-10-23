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
        <div class="stat-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr))">
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
                <div class="stat-label">Absensi tercatat</div>
                <div class="stat-value">{{ $history->count() }} <small>terakhir</small></div>
            </div>
        </div>
    @endif

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
