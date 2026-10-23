<x-app-layout>
    <x-slot name="eyebrow">Data siswa</x-slot>
    <x-slot name="header">Edit Siswa</x-slot>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.students.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="nis">NIS</label>
                    <input id="nis" type="text" name="nis" value="{{ old('nis', $student->nis) }}" class="input @error('nis') is-invalid @enderror" autofocus>
                    @error('nis')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                </div>

                <div class="field">
                    <label for="full_name">Nama Lengkap</label>
                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" class="input @error('full_name') is-invalid @enderror">
                    @error('full_name')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                </div>

                <div class="field">
                    <label for="class_id">Kelas</label>
                    <select id="class_id" name="class_id" class="input @error('class_id') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}@if ($class->major) - {{ $class->major }}@endif
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                </div>

                <div class="field span-2" style="margin-top:6px;padding-top:20px;border-top:1px solid var(--line-soft)">
                    <div class="panel-title" style="font-size:17px">Akun login siswa <span class="panel-note">(opsional)</span></div>
                    <p class="hint">Isi supaya siswa bisa masuk ke aplikasi mobile. Bisa juga diisi nanti lewat Edit.</p>
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $student->user?->email) }}" placeholder="siswa@sekolah.test" class="input @error('email') is-invalid @enderror" autocomplete="off">
                        @error('email')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" class="input @error('password') is-invalid @enderror" autocomplete="new-password">
                        <p class="hint">Minimal 8 karakter. Kosongkan jika tidak diubah.</p>
                        @error('password')<ul class="field-error"><li>{{ $message }}</li></ul>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
