@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="mb-6">
    <a href="{{ route('payments.index') }}" class="text-sm font-semibold text-zinc-400 hover:text-brand">Kembali ke pendapatan</a>
    <h1 class="mt-2 text-3xl font-black">Detail pembayaran</h1>
</div>

<div class="grid gap-6 lg:grid-cols-5">
    <section class="card p-6 lg:col-span-3">
        <dl class="grid gap-6 text-sm sm:grid-cols-2">
            <div>
                <dt class="text-zinc-400">Nama murid</dt>
                <dd class="mt-0.5 text-base font-bold">{{ $payment->student_name }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Periode bulan</dt>
                <dd class="mt-0.5 text-base font-bold">{{ $payment->month_period }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Nominal pembayaran</dt>
                <dd class="mt-0.5 text-2xl font-black tabular-nums text-brand">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-zinc-400">Paket</dt>
                <dd class="mt-0.5 text-base font-bold">4x Pertemuan per Bulan</dd>
            </div>
            <div>
                <dt class="mb-1 text-zinc-400">Status</dt>
                <dd><x-status-badge type="payment" :value="$payment->status" /></dd>
            </div>
            <div>
                <dt class="text-zinc-400">Pengajar</dt>
                <dd class="mt-0.5 font-semibold">{{ $payment->user->name }}</dd>
            </div>
        </dl>

        <div class="mt-8 border-t border-line pt-6">
            @if (auth()->user()->isAdmin())
                @if ($payment->isPaid())
                    <p class="text-sm font-semibold text-brand">Pembayaran ini sudah dikonfirmasi dan masuk ke total pendapatan.</p>
                @else
                    <p class="mb-4 text-sm text-zinc-400">Setujui hanya setelah bukti transfer dari WhatsApp Anda terverifikasi.</p>
                    <form method="POST" action="{{ route('payments.approve', $payment->id) }}"
                          onsubmit="return confirm('Approve pembayaran ini? Nominalnya akan masuk ke total pendapatan.');">
                        @csrf
                        <button type="submit" class="btn-primary">Approve Pembayaran</button>
                    </form>
                @endif
            @else
                <p class="text-sm text-zinc-400">
                    Konfirmasi pembayaran dilakukan murid langsung ke WhatsApp admin. Status di halaman ini diperbarui oleh admin setelah pembayaran terverifikasi.
                </p>
            @endif
        </div>
    </section>

    <section class="card p-6 lg:col-span-2">
        <h2 class="text-lg font-extrabold">Tanggal pertemuan</h2>
        <p class="mt-1 text-sm text-zinc-400">Dari jadwal {{ $payment->month_period }}</p>

        @if ($meetings->isEmpty())
            <p class="mt-5 text-sm text-zinc-500">Belum ada jadwal untuk murid ini pada periode tersebut.</p>
        @else
            <ul class="mt-5 divide-y divide-line">
                @foreach ($meetings as $meeting)
                    <li class="flex items-center justify-between gap-3 py-3 text-sm">
                        <span>
                            <span class="block font-semibold">{{ $meeting->schedule_date->translatedFormat('l, d F Y') }}</span>
                            <span class="block tabular-nums text-zinc-400">{{ $meeting->timeLabel() }} WIB</span>
                        </span>
                        <x-status-badge type="attendance" :value="$meeting->attendance" />
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
@endsection
