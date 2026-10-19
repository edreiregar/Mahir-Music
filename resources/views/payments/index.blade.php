@extends('layouts.app')

@section('title', 'Pendapatan')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black">Pendapatan</h1>
        <p class="mt-1 text-zinc-400">Pembayaran kursus bulanan per murid.</p>
    </div>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('payments.create') }}" class="btn-primary">Catat tagihan</a>
    @endif
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[680px] text-left text-sm">
            <thead class="border-b border-line">
                <tr>
                    <th scope="col" class="th">Murid</th>
                    <th scope="col" class="th">Periode</th>
                    @if (auth()->user()->isAdmin())
                        <th scope="col" class="th">Pengajar</th>
                    @endif
                    <th scope="col" class="th">Nominal</th>
                    <th scope="col" class="th">Status</th>
                    <th scope="col" class="th"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($payments as $payment)
                    <tr class="hover:bg-raised">
                        <td class="td font-semibold">{{ $payment->student_name }}</td>
                        <td class="td">{{ $payment->month_period }}</td>
                        @if (auth()->user()->isAdmin())
                            <td class="td">{{ $payment->user->name }}</td>
                        @endif
                        <td class="td tabular-nums">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                        <td class="td"><x-status-badge type="payment" :value="$payment->status" /></td>
                        <td class="td text-right">
                            <a href="{{ route('payments.show', $payment) }}" class="btn-ghost px-3 py-1.5">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="px-4 py-12 text-center text-zinc-400">
                            Belum ada data pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $payments->links('partials.pager') }}
@endsection
