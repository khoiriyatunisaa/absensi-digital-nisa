<x-app-layout>
    <x-slot name="eyebrow">Master data</x-slot>
    <x-slot name="header">Lokasi QR</x-slot>
    <x-slot name="subtitle">Titik pemasangan QR beserta koordinat dan radius validasi.</x-slot>
    <x-slot name="actions">
        <form method="POST" action="{{ route('admin.qr-tokens.generate') }}">
            @csrf
            <button type="submit" class="btn btn-soft"><x-icon name="refresh" /> Generate QR Hari Ini</button>
        </form>
        <a href="{{ route('admin.qr-locations.create') }}" class="btn btn-primary"><x-icon name="plus" /> Tambah Lokasi</a>
    </x-slot>

    <div class="table-card">
        <div class="table-wrap">
            <table class="table" style="min-width: 860px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Koordinat</th>
                        <th>Radius</th>
                        <th>Status</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $location)
                        @php $todayToken = $location->tokens()->whereDate('date', today())->first(); @endphp
                        <tr>
                            <td class="col-no">{{ $locations->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="strong">{{ $location->name }}</div>
                                <span class="badge badge-code">{{ $location->code }}</span>
                            </td>
                            <td class="mono">{{ $location->latitude }}<br>{{ $location->longitude }}</td>
                            <td>{{ $location->radius }} m</td>
                            <td>
                                @if ($location->is_active)
                                    <span class="badge badge-ok">Aktif</span>
                                @else
                                    <span class="badge badge-off">Nonaktif</span>
                                @endif
                            </td>
                            <td class="col-actions">
                                <div class="row-actions">
                                    @if ($todayToken)
                                        @if ($todayToken->is_active)
                                            <a href="{{ route('admin.qr-tokens.display', $todayToken) }}" target="_blank" class="btn btn-ghost btn-sm"><x-icon name="qr" /> Lihat QR</a>
                                        @endif
                                        <form action="{{ route('admin.qr-tokens.toggle', $todayToken) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-ghost btn-sm" onclick="return confirm('{{ $todayToken->is_active ? 'Nonaktifkan QR hari ini? Siswa tidak bisa absen dengan QR ini.' : 'Aktifkan kembali QR hari ini?' }}')">
                                                <x-icon name="shield" /> {{ $todayToken->is_active ? 'Nonaktifkan QR' : 'Aktifkan QR' }}
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.qr-locations.edit', $location) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> Edit</a>
                                    <form action="{{ route('admin.qr-locations.destroy', $location) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus lokasi ini? Token QR-nya ikut terhapus.')">
                                            <x-icon name="trash" /> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty"><div class="empty-title">Belum ada lokasi QR</div>Tambahkan lokasi seperti Gerbang Utama atau Lab RPL.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($locations->hasPages())
            <div class="table-foot">{{ $locations->links() }}</div>
        @endif
    </div>
</x-app-layout>
