<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QrLocation;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $student?->load('classRoom');

        $todayAttendance = null;
        $monthPresent = 0;
        $history = collect();

        if ($student) {
            $base = Attendance::where('student_id', $student->id);

            $todayAttendance = (clone $base)
                ->with('qrLocation')
                ->whereDate('attendance_date', today())
                ->first();

            $monthPresent = (clone $base)
                ->whereBetween('attendance_date', [
                    now()->startOfMonth()->toDateString(),
                    now()->endOfMonth()->toDateString(),
                ])
                ->where('status', 'hadir')
                ->count();

            $history = (clone $base)
                ->with('qrLocation')
                ->latest('attendance_date')
                ->take(10)
                ->get();
        }

        // Lokasi QR aktif + apakah QR hari ini sudah tersedia (token tidak ditampilkan)
        $locations = QrLocation::where('is_active', true)
            ->with(['tokens' => fn ($q) => $q->whereDate('date', today())])
            ->orderBy('name')
            ->get();

        return view('siswa.dashboard', compact(
            'student', 'todayAttendance', 'monthPresent', 'history', 'locations'
        ));
    }
}
