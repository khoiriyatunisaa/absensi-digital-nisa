<x-app-layout>
    <x-slot name="eyebrow">Lokasi QR</x-slot>
    <x-slot name="header">Edit Lokasi QR</x-slot>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.qr-locations.update', $location) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label for="name">Nama Lokasi</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $location->name) }}" placeholder="Contoh: Gerbang Utama" class="input @error('name') is-invalid @enderror" autofocus>
                        @error('name')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="code">Kode Lokasi</label>
                        <input id="code" type="text" name="code" value="{{ old('code', $location->code) }}" placeholder="Contoh: GERBANG" class="input @error('code') is-invalid @enderror">
                        @error('code')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="latitude">Latitude</label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude', $location->latitude) }}" placeholder="Hasil survei lokasi" class="input @error('latitude') is-invalid @enderror">
                        @error('latitude')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="longitude">Longitude</label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude', $location->longitude) }}" placeholder="Hasil survei lokasi" class="input @error('longitude') is-invalid @enderror">
                        @error('longitude')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field span-2">
                        <label for="radius">Radius (meter)</label>
                        <input id="radius" type="number" name="radius" value="{{ old('radius', $location->radius) }}" class="input @error('radius') is-invalid @enderror">
                        <p class="hint">Jarak maksimum siswa dari titik QR agar absensi dianggap valid (1&ndash;500 m).</p>
                        @error('radius')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field span-2">
                        <label class="check-row">
                            <input type="checkbox" name="is_active" value="1" class="check" {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                            Lokasi aktif
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.qr-locations.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
