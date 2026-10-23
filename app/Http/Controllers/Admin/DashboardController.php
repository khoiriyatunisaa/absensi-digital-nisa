<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\QrLocation;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // /dashboard dipakai bersama: siswa diarahkan ke dashboard siswa.
        $user = auth()->user();

        if ($user->isSiswa()) {
            return redirect()->route('siswa.dashboard');
        }

        abort_unless($user->isAdmin(), 403, 'Akses ditolak.');

        $totalStudents   = Student::count();
        $totalClasses    = ClassRoom::count();
        $activeLocations = QrLocation::where('is_active', true)->count();
        $presentToday    = Attendance::whereDate('attendance_date', today())->count();
        $presentRate     = $totalStudents > 0 ? round($presentToday / $totalStudents * 100) : 0;

        // Kehadiran 7 hari terakhir (termasuk hari ini)
        $start  = today()->subDays(6);
        $counts = DB::table('attendances')
            ->whereBetween('attendance_date', [$start->toDateString(), today()->toDateString()])
            ->selectRaw('attendance_date, COUNT(*) as total')
            ->groupBy('attendance_date')
            ->pluck('total', 'attendance_date');

        $week = collect(range(0, 6))->map(function ($i) use ($start, $counts) {
            $date = $start->copy()->addDays($i);

            return [
                'date'     => $date,
                'count'    => (int) ($counts[$date->toDateString()] ?? 0),
                'is_today' => $date->isToday(),
            ];
        });

        // Lokasi aktif + token hari ini (kalau sudah digenerate)
        $locations = QrLocation::where('is_active', true)
            ->with(['tokens' => fn ($q) => $q->whereDate('date', today())])
            ->orderBy('name')
            ->get();

        $latest = Attendance::with(['student.classRoom', 'qrLocation'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalStudents', 'totalClasses', 'activeLocations',
            'presentToday', 'presentRate', 'week', 'locations', 'latest'
        ));
    }
}
