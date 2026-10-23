<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['classRoom', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::orderBy('class_name')->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis'],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
            // Akun login (opsional). Kalau email diisi, password wajib.
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'required_with:email', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($validated) {
            $userId = null;

            if (!empty($validated['email'])) {
                $userId = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'siswa',
                ])->id;
            }

            Student::create([
                'user_id' => $userId,
                'nis' => $validated['nis'],
                'full_name' => $validated['full_name'],
                'class_id' => $validated['class_id'],
            ]);
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $user = $student->user;

        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis,' . $student->id],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            // Sudah punya akun: password boleh kosong (tidak diubah).
            // Belum punya akun: password wajib kalau email diisi.
            'password' => $user
                ? ['nullable', 'string', 'min:8']
                : ['nullable', 'required_with:email', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($validated, $student, $user) {
            $student->update([
                'nis' => $validated['nis'],
                'full_name' => $validated['full_name'],
                'class_id' => $validated['class_id'],
            ]);

            if ($user) {
                $data = ['name' => $validated['full_name']];

                if (!empty($validated['email'])) {
                    $data['email'] = $validated['email'];
                }
                if (!empty($validated['password'])) {
                    $data['password'] = Hash::make($validated['password']);
                }

                $user->update($data);
            } elseif (!empty($validated['email'])) {
                $newUser = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'siswa',
                ]);

                $student->update(['user_id' => $newUser->id]);
            }
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;

            $student->delete();

            // Akun login siswa ikut dihapus supaya tidak jadi akun yatim.
            if ($user && $user->role === 'siswa') {
                $user->tokens()->delete();
                $user->delete();
            }
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
