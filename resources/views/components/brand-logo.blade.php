@props(['variant' => 'full', 'tagline' => true, 'href' => null])

@if ($variant === 'compact')
    <a href="{{ $href ?? route('landing') }}" {{ $attributes->class(['flex items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-brand']) }}>
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand text-ink ring-2 ring-black">
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6" aria-hidden="true">
                <path d="M12 3v10.55A4 4 0 1 0 14 17V7h4V3h-6z" />
            </svg>
        </span>
        <span class="leading-tight">
            <span class="block text-lg font-black tracking-tight text-white">MAHIR <span class="text-brand">MUSIK</span></span>
            @if ($tagline)
                <span class="block text-[11px] font-medium text-zinc-400">Belajar Musik dari Bisa Menjadi Mahir</span>
            @endif
        </span>
    </a>
@else
    {{-- Logo resmi MAHIR MUSIK (berlatar putih, jadi dibungkus panel putih agar tetap rapi di tema gelap) --}}
    <div {{ $attributes->class(['overflow-hidden rounded-2xl bg-white p-5']) }}>
        <img src="{{ asset('images/logo-mahir-musik.jpeg') }}"
             alt="MAHIR MUSIK. Belajar Musik dari Bisa Menjadi Mahir"
             class="h-auto w-full" width="1202" height="568">
    </div>
@endif
