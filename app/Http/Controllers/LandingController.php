<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Halaman publik murid: read-only. Tidak ada link materi, upload, maupun download.
     * Hanya kolom yang aman yang diambil dari database.
     */
    public function index(): View
    {
        $schedules = Schedule::query()
            ->select(['id', 'user_id', 'student_name', 'schedule_date', 'schedule_time', 'attendance'])
            ->with('user:id,name')
            ->whereDate('schedule_date', '>=', today()->subDays(7))
            ->orderBy('schedule_date')
            ->orderBy('schedule_time')
            ->limit(50)
            ->get();

        return view('landing', compact('schedules'));
    }
}
