<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.students.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded inline-block">
                + Tambah Siswa
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
                            <th class="p-3 text-left">NIS</th>
                            <th class="p-3 text-left">Nama Lengkap</th>
                            <th class="p-3 text-left">Kelas</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr class="border-b">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $student->nis }}</td>
                                <td class="p-3">{{ $student->full_name }}</td>
                                <td class="p-3">{{ $student->classRoom->class_name }}</td>
                                <td class="p-3">
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                       class="text-blue-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}"
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
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>