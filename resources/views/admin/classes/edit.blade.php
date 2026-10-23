<x-app-layout>
    <x-slot name="eyebrow">Data kelas</x-slot>
    <x-slot name="header">Edit Kelas</x-slot>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.classes.update', $class) }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="class_name">Nama Kelas</label>
                    <input id="class_name" type="text" name="class_name" value="{{ old('class_name', $class->class_name) }}" class="input @error('class_name') is-invalid @enderror" autofocus>
                    @error('class_name')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                </div>

                <div class="field">
                    <label for="major">Jurusan</label>
                    <input id="major" type="text" name="major" value="{{ old('major', $class->major) }}" class="input @error('major') is-invalid @enderror">
                    @error('major')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
