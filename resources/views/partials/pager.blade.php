@if ($paginator->hasPages())
    <nav class="mt-4 flex items-center justify-between text-sm text-zinc-400" aria-label="Navigasi halaman">
        <span>Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
        <div class="flex gap-2">
            @if ($paginator->onFirstPage())
                <span class="btn-ghost pointer-events-none opacity-40">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn-ghost">Sebelumnya</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-ghost">Berikutnya</a>
            @else
                <span class="btn-ghost pointer-events-none opacity-40">Berikutnya</span>
            @endif
        </div>
    </nav>
@endif
