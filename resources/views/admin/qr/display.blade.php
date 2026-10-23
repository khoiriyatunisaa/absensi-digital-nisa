<x-app-layout>
    <x-slot name="eyebrow">QR absensi</x-slot>
    <x-slot name="header">{{ $qrToken->location->name }}</x-slot>
    <x-slot name="subtitle">Tempel atau tampilkan QR ini di lokasi. Token otomatis tidak berlaku setelah waktu di bawah.</x-slot>
    <x-slot name="actions">
        <a href="{{ route('admin.qr-locations.index') }}" class="btn btn-ghost"><x-icon name="back" /> Kembali</a>
        <button type="button" class="btn btn-primary" onclick="window.print()"><x-icon name="printer" /> Cetak</button>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="qr-stage">
                <p class="qr-name">{{ $qrToken->location->name }}</p>
                <div class="qr-meta">Kode lokasi <span class="badge badge-code">{{ $qrToken->location->code }}</span></div>

                <div class="qr-frame">
                    {!! QrCode::size(300)->generate($url) !!}
                </div>

                <div class="qr-meta">
                    Berlaku sampai <strong>{{ $qrToken->valid_until->format('d-m-Y H:i:s') }}</strong>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
