<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use App\Support\Bulan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Admin melihat semua data; pengajar hanya data miliknya.
        $schedules = fn () => $user->isAdmin()
            ? Schedule::query()
            : Schedule::query()->where('user_id', $user->id);

        $payments = fn () => $user->isAdmin()
            ? Payment::query()
            : Payment::query()->where('user_id', $user->id);

        // Kartu ringkasan
        $totalStudents = $schedules()->pluck('student_name')
            ->map(fn ($name) => mb_strtolower(trim($name)))
            ->unique()
            ->count();

        $absentCount = $schedules()->where('attendance', 'absen')->count();

        // Total pendapatan: HANYA payment berstatus 'sudah_bayar' (setelah di-approve admin).
        $totalRevenue = (float) $payments()->where('status', 'sudah_bayar')->sum('amount');

        // 12 bulan terakhir (terlama -> terbaru)
        $months = collect(range(11, 0))->map(fn (int $i) => now()->startOfMonth()->subMonths($i));

        $chartLabels = $months
            ->map(fn ($date) => mb_substr(Bulan::NAMES[$date->month], 0, 3).' '.$date->format('y'))
            ->all();

        // Bar chart: jumlah murid unik per bulan (berdasarkan jadwal)
        $rows = $schedules()
            ->whereBetween('schedule_date', [
                $months->first()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ])
            ->get(['student_name', 'schedule_date'])
            ->groupBy(fn ($row) => $row->schedule_date->format('Y-m'));

        $studentSeries = $months->map(function ($date) use ($rows) {
            $group = $rows->get($date->format('Y-m'));

            return $group === null ? 0 : $group->pluck('student_name')
                ->map(fn ($name) => mb_strtolower(trim($name)))
                ->unique()
                ->count();
        })->all();

        // Line chart: total nominal pendapatan per bulan (hanya 'sudah_bayar')
        $revenueByPeriod = $payments()
            ->where('status', 'sudah_bayar')
            ->get(['month_period', 'amount'])
            ->groupBy(fn ($payment) => Bulan::normalize($payment->month_period))
            ->map(fn ($group) => (float) $group->sum('amount'));

        $revenueSeries = $months
            ->map(fn ($date) => $revenueByPeriod->get(Bulan::label($date), 0.0))
            ->all();

        return view('dashboard', compact(
            'totalStudents',
            'absentCount',
            'totalRevenue',
            'chartLabels',
            'studentSeries',
            'revenueSeries',
        ));
    }
}
