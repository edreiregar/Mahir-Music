@extends('layouts.guest')

@section('title', 'Masuk | MAHIR MUSIK')

@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    @include('auth._aside')

    <div class="flex items-center justify-center px-4 py-12 sm:px-8">
        <div class="w-full max-w-md">
            <div class="mb-8 lg:hidden">
                <x-brand-logo variant="compact" />
            </div>

            <h1 class="text-3xl font-black">Login ke MAHIR MUSIK</h1>
            <p class="mt-2 text-sm text-zinc-400">Gunakan akun pengajar atau admin untuk membuka dashboard.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="field">
                    @error('email') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="label">Kata sandi</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="field">
                    @error('password') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-line bg-ink text-brand focus:ring-brand">
                    Ingat saya di perangkat ini
                </label>

                <button type="submit" class="btn-primary w-full">Masuk</button>
            </form>

            <p class="mt-6 text-sm text-zinc-400">
                Belum punya akun pengajar?
                <a href="{{ route('register') }}" class="font-bold text-brand hover:underline">Daftar sekarang</a>
            </p>
            <p class="mt-2 text-sm text-zinc-400">
                <a href="{{ route('landing') }}" class="font-semibold text-zinc-300 hover:text-brand">Kembali ke jadwal latihan</a>
            </p>
        </div>
    </div>
</div>
@endsection
