<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Siswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.students.store') }}">
                    @csrf

                    <div>
                        <label>NIS</label>
                        <input type="text" name="nis" value="{{ old('nis') }}"
                               class="w-full border rounded">
                        @error('nis')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                               class="w-full border rounded">
                        @error('full_name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label>Kelas</label>
                        <select name="class_id" class="w-full border rounded">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} - {{ $class->major }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>