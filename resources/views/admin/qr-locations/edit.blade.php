<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Lokasi QR</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.qr-locations.update', $location) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label>Nama Lokasi</label>
                        <input type="text" name="name"
                               value="{{ old('name', $location->name) }}"
                               class="w-full border rounded">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Kode Lokasi</label>
                        <input type="text" name="code"
                               value="{{ old('code', $location->code) }}"
                               class="w-full border rounded">
                        @error('code')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Latitude</label>
                        <input type="text" name="latitude"
                               value="{{ old('latitude', $location->latitude) }}"
                               class="w-full border rounded">
                        @error('latitude')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Longitude</label>
                        <input type="text" name="longitude"
                               value="{{ old('longitude', $location->longitude) }}"
                               class="w-full border rounded">
                        @error('longitude')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Radius (meter)</label>
                        <input type="number" name="radius"
                               value="{{ old('radius', $location->radius) }}"
                               class="w-full border rounded">
                        @error('radius')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>

                    <button class="mt-6 px-4 py-2 bg-green-600 text-white rounded">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>