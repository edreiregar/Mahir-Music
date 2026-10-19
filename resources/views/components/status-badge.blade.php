@props(['type', 'value'])

@php
    $yellow = 'bg-brand/15 text-brand ring-brand/30';
    $gray = 'bg-zinc-500/10 text-zinc-300 ring-zinc-400/20';
    $red = 'bg-red-500/10 text-red-300 ring-red-400/30';

    $map = [
        'attendance' => [
            'hadir' => ['Hadir', $yellow],
            'absen' => ['Tidak hadir', $red],
            'belum_absen' => ['Belum absen', $gray],
        ],
        'payment' => [
            'sudah_bayar' => ['Sudah bayar', $yellow],
            'belum_bayar' => ['Belum bayar', $gray],
        ],
    ];

    [$label, $classes] = $map[$type][$value] ?? [$value, $gray];
@endphp

<span class="inline-flex items-center whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $classes }}">{{ $label }}</span>
