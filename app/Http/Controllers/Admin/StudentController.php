<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('classRoom')
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
        ]);

        Student::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::orderBy('class_name')->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis,' . $student->id],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}