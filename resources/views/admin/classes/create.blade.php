<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Kelas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.classes.store') }}">
                    @csrf
                    <div>
                        <label>Nama Kelas</label>
                        <input type="text" name="class_name" value="{{ old('class_name') }}"
                               class="w-full border rounded">
                        @error('class_name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Jurusan</label>
                        <input type="text" name="major" value="{{ old('major') }}"
                               class="w-full border rounded">
                    </div>

                    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>