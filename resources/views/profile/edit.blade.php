@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-black">Profil</h1>
    <p class="mt-1 text-zinc-400">Perbarui data diri dan kata sandi Anda.</p>
</div>

<form method="POST" action="{{ route('profile.update') }}" class="card max-w-xl space-y-5 p-6">
    @csrf
    @method('PATCH')

    <div>
        <label for="name" class="label">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" class="field">
        @error('name') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="field">
        @error('email') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="border-t border-line pt-5">
        <h2 class="text-base font-extrabold">Ganti kata sandi</h2>
        <p class="mt-1 text-sm text-zinc-400">Kosongkan bagian ini jika tidak ingin mengubah kata sandi.</p>

        <div class="mt-4 space-y-5">
            <div>
                <label for="current_password" class="label">Kata sandi saat ini</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="field">
                @error('current_password') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="label">Kata sandi baru</label>
                <input id="password" name="password" type="password" autocomplete="new-password" class="field">
                @error('password') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="label">Ulangi kata sandi baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="field">
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary">Simpan profil</button>
</form>
@endsection
