@extends('layouts.guest')

@section('title', 'MAHIR MUSIK | Belajar Musik dari Bisa Menjadi Mahir')

@section('content')
<header class="border-b border-line">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <x-brand-logo variant="compact" />
        <nav class="flex items-center gap-2" aria-label="Akses pengajar">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary">Buka dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Login</a>
                <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-flex">Register Pengajar</a>
            @endauth
        </nav>
    </div>
</header>

<section class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:py-20">
    <div>
        <h1 class="text-4xl font-black leading-[1.1] sm:text-5xl">Belajar Musik dari Bisa Menjadi Mahir</h1>
        <div class="mt-6 h-1.5 w-28 rounded-full bg-brand"></div>
        <p class="mt-6 max-w-md text-lg leading-relaxed text-zinc-300">
            MAHIR MUSIK menyusun latihan secara terjadwal bersama pengajar. Lihat jadwal latihan yang sedang berjalan di bawah ini.
        </p>
        <a href="#jadwal" class="btn-primary mt-8">Lihat jadwal latihan</a>
    </div>

    <x-brand-logo class="mx-auto w-full max-w-lg shadow-2xl shadow-black/60" />
</section>

<section id="jadwal" class="mx-auto max-w-6xl px-4 pb-20 sm:px-6">
    <h2 class="text-2xl font-extrabold">Jadwal pengajar aktif</h2>
    <p class="mt-1 text-sm text-zinc-400">Menampilkan jadwal 7 hari terakhir dan yang akan datang. Halaman ini hanya untuk dilihat.</p>

    <div class="card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-line">
                    <tr>
                        <th scope="col" class="th">Tanggal</th>
                        <th scope="col" class="th">Waktu</th>
                        <th scope="col" class="th">Pengajar</th>
                        <th scope="col" class="th">Murid</th>
                        <th scope="col" class="th">Status absensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($schedules as $schedule)
                        <tr class="hover:bg-raised">
                            <td class="td font-semibold">{{ $schedule->schedule_date->translatedFormat('l, d F Y') }}</td>
                            <td class="td tabular-nums">{{ $schedule->timeLabel() }} WIB</td>
                            <td class="td">{{ $schedule->user->name }}</td>
                            <td class="td">{{ \Illuminate\Support\Str::before(trim($schedule->student_name), ' ') }}</td>
                            <td class="td"><x-status-badge type="attendance" :value="$schedule->attendance" /></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-zinc-400">Belum ada jadwal latihan aktif. Cek lagi nanti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<footer class="border-t border-line">
    <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-zinc-500 sm:px-6">
        &copy; {{ date('Y') }} MAHIR MUSIK. Belajar Musik dari Bisa Menjadi Mahir.
    </div>
</footer>
@endsection
