@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="mb-6">
    <a href="{{ route('schedules.index') }}" class="text-sm font-semibold text-zinc-400 hover:text-brand">Kembali ke jadwal</a>
    <h1 class="mt-2 text-3xl font-black">Tambah jadwal</h1>
</div>

<form method="POST" action="{{ route('schedules.store') }}" class="card max-w-xl space-y-5 p-6">
    @csrf

    @if (auth()->user()->isAdmin())
        <div>
            <label for="user_id" class="label">Pengajar</label>
            <select id="user_id" name="user_id" required class="field">
                <option value="">Pilih pengajar</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('user_id') == $teacher->id)>{{ $teacher->name }}</option>
                @endforeach
            </select>
            @error('user_id') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    @endif

    <div>
        <label for="student_name" class="label">Nama murid</label>
        <input id="student_name" name="student_name" type="text" value="{{ old('student_name') }}" required class="field">
        @error('student_name') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="schedule_date" class="label">Tanggal</label>
            <input id="schedule_date" name="schedule_date" type="date" value="{{ old('schedule_date') }}" required class="field">
            @error('schedule_date') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="schedule_time" class="label">Waktu</label>
            <input id="schedule_time" name="schedule_time" type="time" value="{{ old('schedule_time') }}" required class="field">
            @error('schedule_time') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    <button type="submit" class="btn-primary">Simpan jadwal</button>
</form>
@endsection
