@extends('layouts.guest')

@section('title', 'Daftar Pengajar | MAHIR MUSIK')

@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    @include('auth._aside')

    <div class="flex items-center justify-center px-4 py-12 sm:px-8">
        <div class="w-full max-w-md">
            <div class="mb-8 lg:hidden">
                <x-brand-logo variant="compact" />
            </div>

            <h1 class="text-3xl font-black">Daftar sebagai pengajar</h1>
            <p class="mt-2 text-sm text-zinc-400">Setiap akun baru otomatis terdaftar sebagai pengajar MAHIR MUSIK.</p>

            <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="name" class="label">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="field">
                    @error('name') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="field">
                    @error('email') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="label">Nomor telepon (opsional)</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" class="field" placeholder="0812 3456 7890">
                    @error('phone') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="label">Kata sandi</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="field">
                    @error('password') <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="label">Ulangi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="field">
                </div>

                <button type="submit" class="btn-primary w-full">Buat akun pengajar</button>
            </form>

            <p class="mt-6 text-sm text-zinc-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-brand hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
