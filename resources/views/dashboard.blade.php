@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black">Halo, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</h1>
    <p class="mt-1 text-zinc-400">
        {{ auth()->user()->isAdmin() ? 'Ringkasan seluruh murid dan pendapatan MAHIR MUSIK.' : 'Ringkasan murid dan pendapatan dari kelas yang Anda ampu.' }}
    </p>
</div>

<div class="grid gap-4 md:grid-cols-3">
    <section class="card p-6">
        <h2 class="text-sm font-semibold text-zinc-400">Jumlah murid</h2>
        <p class="mt-3 text-4xl font-black tabular-nums">{{ number_format($totalStudents, 0, ',', '.') }}</p>
        <p class="mt-2 text-sm text-zinc-500">Murid unik yang diampu</p>
    </section>

    <section class="card p-6">
        <h2 class="text-sm font-semibold text-zinc-400">Murid yang absen</h2>
        <p class="mt-3 text-4xl font-black tabular-nums">{{ number_format($absentCount, 0, ',', '.') }}</p>
        <p class="mt-2 text-sm text-zinc-500">Total pertemuan berstatus tidak hadir</p>
    </section>

    <section class="rounded-xl bg-brand p-6 text-ink">
        <h2 class="text-sm font-bold text-black/70">Total pendapatan</h2>
        <p class="mt-3 text-4xl font-black tabular-nums">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="mt-2 text-sm font-medium text-black/70">Hanya pembayaran yang sudah di-approve admin</p>
    </section>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="card p-6">
        <h2 class="text-lg font-extrabold">Jumlah murid per bulan</h2>
        <p class="mb-4 text-sm text-zinc-400">12 bulan terakhir</p>
        <div class="relative h-72">
            <canvas id="studentsChart" role="img" aria-label="Grafik batang jumlah murid per bulan"></canvas>
        </div>
    </section>

    <section class="card p-6">
        <h2 class="text-lg font-extrabold">Pendapatan per bulan</h2>
        <p class="mb-4 text-sm text-zinc-400">Berdasarkan pembayaran berstatus sudah bayar</p>
        <div class="relative h-72">
            <canvas id="revenueChart" role="img" aria-label="Grafik garis total pendapatan per bulan"></canvas>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const YELLOW = '#FACC15';
        const YELLOW_DARK = '#EAB308';
        const GRID = 'rgba(255, 255, 255, 0.06)';

        const labels = @json($chartLabels);
        const studentSeries = @json($studentSeries);
        const revenueSeries = @json($revenueSeries);

        const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
        const compact = new Intl.NumberFormat('id-ID', { notation: 'compact', maximumFractionDigits: 1 });

        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.font.family = 'Archivo, ui-sans-serif, system-ui, sans-serif';

        const tooltip = {
            backgroundColor: '#1E1E22',
            borderColor: '#2C2C31',
            borderWidth: 1,
            titleColor: '#F3F4F6',
            bodyColor: '#F3F4F6',
            padding: 10,
        };

        new Chart(document.getElementById('studentsChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah murid',
                    data: studentSeries,
                    backgroundColor: YELLOW,
                    hoverBackgroundColor: YELLOW_DARK,
                    borderRadius: 6,
                    maxBarThickness: 34,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: Object.assign({}, tooltip, {
                        callbacks: { label: (ctx) => ctx.parsed.y + ' murid' },
                    }),
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: GRID } },
                },
            },
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total pendapatan',
                    data: revenueSeries,
                    borderColor: YELLOW,
                    backgroundColor: 'rgba(250, 204, 21, 0.12)',
                    pointBackgroundColor: YELLOW,
                    pointBorderColor: '#0F0F11',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: Object.assign({}, tooltip, {
                        callbacks: { label: (ctx) => rupiah.format(ctx.parsed.y) },
                    }),
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: GRID },
                        ticks: { callback: (value) => 'Rp ' + compact.format(value) },
                    },
                },
            },
        });
    })();
</script>
@endpush
