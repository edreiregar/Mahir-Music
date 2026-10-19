@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-black">Settings</h1>
    <p class="mt-1 text-zinc-400">Pengaturan dasar akun Anda.</p>
</div>

<div class="max-w-xl space-y-6">
    <section class="card p-6">
        <h2 class="text-lg font-extrabold">Informasi akun</h2>
        <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
            <div>
                <dt class="text-zinc-400">Peran</dt>
                <dd class="mt-0.5 font-bold">{{ $user->isAdmin() ? 'Admin' : 'Pengajar' }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Bergabung sejak</dt>
                <dd class="mt-0.5 font-bold">{{ $user->created_at->translatedFormat('d F Y') }}</dd>
            </div>
        </dl>
    </section>

    <form method="POST" action="{{ route('settings.update') }}" class="card space-y-5 p-6">
        @csrf
        @method('PATCH')

        <h2 class="text-lg font-extrabold">Kontak</h2>

        <div>
            <label for="phone" class="label">Nomor telepon</label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" autocomplete="tel" class="field" placeholder="0812 3456 7890">
            @error('phone') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary">Simpan pengaturan</button>
    </form>

    <form method="POST" action="{{ route('settings.destroy') }}" class="card space-y-4 border-red-500/30 p-6"
          onsubmit="return confirm('Hapus akun ini secara permanen? Jadwal dan pembayaran milik akun ini ikut terhapus.');">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-extrabold text-red-300">Hapus akun</h2>
        <p class="text-sm text-zinc-400">Seluruh jadwal dan data pembayaran milik akun ini akan ikut terhapus dan tidak bisa dikembalikan.</p>

        <div>
            <label for="delete_password" class="label">Kata sandi saat ini</label>
            <input id="delete_password" name="password" type="password" required autocomplete="current-password" class="field">
            @error('password') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-danger">Hapus akun</button>
    </form>
</div>
@endsection
