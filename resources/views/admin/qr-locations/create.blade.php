<x-app-layout>
    <x-slot name="eyebrow">Lokasi QR</x-slot>
    <x-slot name="header">Tambah Lokasi QR</x-slot>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.qr-locations.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label for="name">Nama Lokasi</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Gerbang Utama" class="input @error('name') is-invalid @enderror" autofocus>
                        @error('name')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="code">Kode Lokasi</label>
                        <input id="code" type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: GERBANG" class="input @error('code') is-invalid @enderror">
                        @error('code')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="latitude">Latitude</label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude') }}" placeholder="Hasil survei lokasi" class="input @error('latitude') is-invalid @enderror">
                        @error('latitude')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="longitude">Longitude</label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude') }}" placeholder="Hasil survei lokasi" class="input @error('longitude') is-invalid @enderror">
                        @error('longitude')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field span-2">
                        <label for="radius">Radius (meter)</label>
                        <input id="radius" type="number" name="radius" value="{{ old('radius', 50) }}" class="input @error('radius') is-invalid @enderror">
                        <p class="hint">Jarak maksimum siswa dari titik QR agar absensi dianggap valid (1&ndash;500 m).</p>
                        @error('radius')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field span-2">
                        <label class="check-row">
                            <input type="checkbox" name="is_active" value="1" class="check" {{ old('is_active', true) ? 'checked' : '' }}>
                            Lokasi aktif
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.qr-locations.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
