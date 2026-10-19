@extends('layouts.app')

@section('title', 'Catat Tagihan')

@section('content')
<div class="mb-6">
    <a href="{{ route('payments.index') }}" class="text-sm font-semibold text-zinc-400 hover:text-brand">Kembali ke pendapatan</a>
    <h1 class="mt-2 text-3xl font-black">Catat tagihan</h1>
    <p class="mt-1 text-zinc-400">Tagihan baru berstatus belum bayar sampai Anda meng-approve pembayarannya.</p>
</div>

<form method="POST" action="{{ route('payments.store') }}" class="card max-w-xl space-y-5 p-6">
    @csrf

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

    <div>
        <label for="student_name" class="label">Nama murid</label>
        <input id="student_name" name="student_name" type="text" value="{{ old('student_name') }}" required class="field">
        @error('student_name') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="month" class="label">Bulan</label>
            <select id="month" name="month" required class="field">
                @foreach ($months as $number => $name)
                    <option value="{{ $number }}" @selected((int) old('month', now()->month) === $number)>{{ $name }}</option>
                @endforeach
            </select>
            @error('month') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="year" class="label">Tahun</label>
            <input id="year" name="year" type="number" min="2020" max="2100" value="{{ old('year', now()->year) }}" required class="field">
            @error('year') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="amount" class="label">Nominal pembayaran (Rp)</label>
        <input id="amount" name="amount" type="number" min="0" step="1000" value="{{ old('amount') }}" required class="field" placeholder="400000">
        <p class="mt-1.5 text-xs text-zinc-500">Biaya kursus per murid untuk 4x pertemuan dalam satu bulan.</p>
        @error('amount') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn-primary">Simpan tagihan</button>
</form>
@endsection
