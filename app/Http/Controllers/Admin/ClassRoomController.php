<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:100'],
            'major' => ['nullable', 'string', 'max:100'],
        ]);

        ClassRoom::create($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(ClassRoom $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:100'],
            'major' => ['nullable', 'string', 'max:100'],
        ]);

        $class->update($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}