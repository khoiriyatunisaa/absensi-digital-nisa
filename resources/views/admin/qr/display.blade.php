<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">QR Absensi</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 text-center">
        <h1 class="text-2xl font-bold">
            {{ $qrToken->location->name }}
        </h1>
        <p class="mt-2 text-gray-600">
            Kode Lokasi: {{ $qrToken->location->code }}
        </p>

        <div class="mt-6 flex justify-center">
            {!! QrCode::size(300)->generate($url) !!}
        </div>

        <p class="mt-4 text-sm text-gray-600">
            Berlaku sampai: {{ $qrToken->valid_until->format('d-m-Y H:i:s') }}
        </p>
    </div>
</x-app-layout>