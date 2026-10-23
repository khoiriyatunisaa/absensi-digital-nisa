<x-app-layout>
    <x-slot name="eyebrow">Master data</x-slot>
    <x-slot name="header">Data Siswa</x-slot>
    <x-slot name="subtitle">Daftar siswa beserta NIS dan kelasnya.</x-slot>
    <x-slot name="actions">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><x-icon name="plus" /> Tambah Siswa</a>
    </x-slot>

    <div class="table-card">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Akun</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="col-no">{{ $students->firstItem() + $loop->index }}</td>
                            <td class="mono">{{ $student->nis }}</td>
                            <td class="strong">{{ $student->full_name }}</td>
                            <td>
                                @if ($student->classRoom)
                                    <span class="badge badge-code">{{ $student->classRoom->class_name }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($student->user)
                                    <span class="badge badge-ok">Ada</span>
                                @else
                                    <span class="badge badge-off">Belum</span>
                                @endif
                            </td>
                            <td class="col-actions">
                                <div class="row-actions">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> Edit</a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data siswa ini?')">
                                            <x-icon name="trash" /> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty"><div class="empty-title">Belum ada siswa</div>Klik &ldquo;Tambah Siswa&rdquo; untuk mulai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($students->hasPages())
            <div class="table-foot">{{ $students->links() }}</div>
        @endif
    </div>
</x-app-layout>
