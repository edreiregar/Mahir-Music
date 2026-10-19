<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ganti kata sandi ini segera setelah login pertama.
        $admin = new User(['name' => 'Admin Mahir Musik', 'email' => 'admin@mahirmusik.test', 'password' => 'Admin#2026!', 'phone' => '081200000000']);
        $admin->role = 'admin';
        $admin->save();

        $pengajar = new User(['name' => 'Rina Pengajar', 'email' => 'rina@mahirmusik.test', 'password' => 'Pengajar#2026!', 'phone' => '081211111111']);
        $pengajar->role = 'pengajar';
        $pengajar->save();

        $murid = ['Budi Santoso', 'Citra Lestari', 'Dimas Pratama'];

        foreach ($murid as $i => $nama) {
            foreach ([1, 8, 15, 22] as $hari) {
                Schedule::create([
                    'user_id' => $pengajar->id,
                    'student_name' => $nama,
                    'schedule_date' => now()->startOfMonth()->addDays($hari - 1 + $i),
                    'schedule_time' => sprintf('%02d:00', 15 + $i),
                    'attendance' => $hari < 15 ? ($hari === 8 && $i === 1 ? 'absen' : 'hadir') : 'belum_absen',
                ]);
            }

            Payment::create([
                'user_id' => $pengajar->id,
                'student_name' => $nama,
                'month_period' => \App\Support\Bulan::label(now()),
                'total_meetings' => 4,
                'status' => $i === 0 ? 'sudah_bayar' : 'belum_bayar',
                'amount' => 400000,
            ]);
        }
    }
}
