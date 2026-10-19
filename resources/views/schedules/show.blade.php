@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
<div class="mb-6">
    <a href="{{ route('schedules.index') }}" class="text-sm font-semibold text-zinc-400 hover:text-brand">Kembali ke jadwal</a>
    <h1 class="mt-2 text-3xl font-black">Detail latihan</h1>
</div>

<div class="grid gap-6 lg:grid-cols-5">
    <section class="card p-6 lg:col-span-2">
        <h2 class="text-lg font-extrabold">Informasi jadwal</h2>
        <dl class="mt-5 space-y-4 text-sm">
            <div>
                <dt class="text-zinc-400">Murid</dt>
                <dd class="mt-0.5 text-base font-bold">{{ $schedule->student_name }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Pengajar</dt>
                <dd class="mt-0.5 font-semibold">{{ $schedule->user->name }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Tanggal</dt>
                <dd class="mt-0.5 font-semibold">{{ $schedule->schedule_date->translatedFormat('l, d F Y') }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Waktu</dt>
                <dd class="mt-0.5 font-semibold tabular-nums">{{ $schedule->timeLabel() }} WIB</dd>
            </div>
            <div>
                <dt class="mb-1 text-zinc-400">Kehadiran saat ini</dt>
                <dd><x-status-badge type="attendance" :value="$schedule->attendance" /></dd>
            </div>
        </dl>
    </section>

    <section class="card p-6 lg:col-span-3">
        <h2 class="text-lg font-extrabold">Absensi dan materi</h2>

        <form method="POST" action="{{ route('schedules.update', $schedule) }}" enctype="multipart/form-data" class="mt-5 space-y-6">
            @csrf
            @method('PATCH')

            <fieldset>
                <legend class="label">Status kehadiran</legend>
                <div class="mt-2 grid gap-3 sm:grid-cols-3">
                    @foreach (['hadir' => 'Hadir', 'absen' => 'Tidak hadir', 'belum_absen' => 'Belum absen'] as $value => $label)
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-line bg-ink px-4 py-3 text-sm font-semibold has-[:checked]:border-brand has-[:checked]:bg-brand/10 has-[:checked]:text-brand">
                            <input type="radio" name="attendance" value="{{ $value }}" class="h-4 w-4 border-line bg-ink text-brand focus:ring-brand"
                                   @checked(old('attendance', $schedule->attendance) === $value)>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                @error('attendance') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
            </fieldset>

            <div>
                <label for="material_file" class="label">Unggah materi musik</label>
                <input id="material_file" name="material_file" type="file"
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp3,.wav,.mp4"
                       class="field file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-brand file:px-3 file:py-1.5 file:text-sm file:font-bold file:text-ink">
                <p class="mt-1.5 text-xs text-zinc-500">PDF, Word, PowerPoint, gambar, MP3, WAV, atau MP4. Maksimal 20 MB. File disimpan privat dan hanya bisa diunduh setelah login.</p>
                @error('material_file') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary">Simpan absensi dan materi</button>
        </form>

        <div class="mt-8 border-t border-line pt-6">
            <h3 class="text-sm font-bold text-zinc-300">Materi tersimpan</h3>
            @if ($schedule->material_file)
                <a href="{{ route('schedules.material', $schedule) }}" class="btn-ghost mt-3">Unduh materi</a>
            @else
                <p class="mt-2 text-sm text-zinc-500">Belum ada materi yang diunggah untuk pertemuan ini.</p>
            @endif
        </div>

        <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="mt-8 border-t border-line pt-6"
              onsubmit="return confirm('Hapus jadwal ini beserta materinya?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Hapus jadwal</button>
        </form>
    </section>
</div>
@endsection
