<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Lokasi QR</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.qr-locations.store') }}">
                    @csrf

                    <div>
                        <label>Nama Lokasi</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Kode Lokasi</label>
                        <input type="text" name="code" value="{{ old('code') }}"
                               placeholder="Contoh: GERBANG"
                               class="w-full border rounded">
                        @error('code')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}"
                               placeholder="Contoh: -6.9147000"
                               class="w-full border rounded">
                        @error('latitude')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}"
                               placeholder="Contoh: 108.4567000"
                               class="w-full border rounded">
                        @error('longitude')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Radius (meter)</label>
                        <input type="number" name="radius" value="{{ old('radius', 50) }}"
                               class="w-full border rounded">
                        @error('radius')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>

                    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>