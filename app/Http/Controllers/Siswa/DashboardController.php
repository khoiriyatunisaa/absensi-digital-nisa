<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $student?->load('classRoom');

        $history = $student
            ? Attendance::with('qrLocation')
                ->where('student_id', $student->id)
                ->latest('attendance_date')
                ->take(10)
                ->get()
            : collect();

        return view('siswa.dashboard', compact('student', 'history'));
    }
}
