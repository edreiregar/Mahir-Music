@extends('layouts.app')

@section('title', 'Absensi & Jadwal')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black">Absensi &amp; Jadwal</h1>
        <p class="mt-1 text-zinc-400">{{ auth()->user()->isAdmin() ? 'Semua jadwal mengajar.' : 'Jadwal mengajar Anda.' }}</p>
    </div>
    <a href="{{ route('schedules.create') }}" class="btn-primary">Tambah jadwal</a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-line">
                <tr>
                    <th scope="col" class="th">Tanggal</th>
                    <th scope="col" class="th">Waktu</th>
                    <th scope="col" class="th">Murid</th>
                    @if (auth()->user()->isAdmin())
                        <th scope="col" class="th">Pengajar</th>
                    @endif
                    <th scope="col" class="th">Kehadiran</th>
                    <th scope="col" class="th">Materi</th>
                    <th scope="col" class="th"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($schedules as $schedule)
                    <tr class="hover:bg-raised">
                        <td class="td font-semibold">{{ $schedule->schedule_date->translatedFormat('d M Y') }}</td>
                        <td class="td tabular-nums">{{ $schedule->timeLabel() }}</td>
                        <td class="td">{{ $schedule->student_name }}</td>
                        @if (auth()->user()->isAdmin())
                            <td class="td">{{ $schedule->user->name }}</td>
                        @endif
                        <td class="td"><x-status-badge type="attendance" :value="$schedule->attendance" /></td>
                        <td class="td text-zinc-400">{{ $schedule->material_file ? 'Sudah diunggah' : 'Belum ada' }}</td>
                        <td class="td text-right">
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn-ghost px-3 py-1.5">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="px-4 py-12 text-center text-zinc-400">
                            Belum ada jadwal. Pilih "Tambah jadwal" untuk membuat jadwal latihan pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $schedules->links('partials.pager') }}
@endsection
