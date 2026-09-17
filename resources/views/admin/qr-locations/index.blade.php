<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lokasi QR
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.qr-locations.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded inline-block">
                + Tambah Lokasi
            </a>

            @if(session('success'))
                <div class="mt-4 p-3 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-4 bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Nama Lokasi</th>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-left">Latitude</th>
                            <th class="p-3 text-left">Longitude</th>
                            <th class="p-3 text-left">Radius (m)</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr class="border-b">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $location->name }}</td>
                                <td class="p-3">{{ $location->code }}</td>
                                <td class="p-3">{{ $location->latitude }}</td>
                                <td class="p-3">{{ $location->longitude }}</td>
                                <td class="p-3">{{ $location->radius }}</td>
                                <td class="p-3">
                                    @if($location->is_active)
                                        <span class="text-green-600">Aktif</span>
                                    @else
                                        <span class="text-red-600">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('admin.qr-locations.edit', $location) }}"
                                       class="text-blue-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.qr-locations.destroy', $location) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-3"
                                                onclick="return confirm('Hapus data?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>