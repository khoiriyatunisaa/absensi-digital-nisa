<x-app-layout>
    <x-slot name="eyebrow">Master data</x-slot>
    <x-slot name="header">Data Kelas</x-slot>
    <x-slot name="subtitle">Kelola daftar kelas dan jurusan yang dipakai pada data siswa.</x-slot>
    <x-slot name="actions">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary"><x-icon name="plus" /> Tambah Kelas</a>
    </x-slot>

    <div class="table-card">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jurusan</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classes as $class)
                        <tr>
                            <td class="col-no">{{ $classes->firstItem() + $loop->index }}</td>
                            <td class="strong">{{ $class->class_name }}</td>
                            <td>{{ $class->major ?: '-' }}</td>
                            <td class="col-actions">
                                <div class="row-actions">
                                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> Edit</a>
                                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas ini? Siswa di kelas ini ikut terhapus.')">
                                            <x-icon name="trash" /> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty"><div class="empty-title">Belum ada kelas</div>Klik &ldquo;Tambah Kelas&rdquo; untuk mulai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($classes->hasPages())
            <div class="table-foot">{{ $classes->links() }}</div>
        @endif
    </div>
</x-app-layout>
