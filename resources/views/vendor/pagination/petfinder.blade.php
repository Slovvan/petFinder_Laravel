@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-secondary btn-sm" aria-disabled="true">‹ Anterior</span>
        @else
            <a class="btn btn-outline btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Anterior</a>
        @endif

        <span class="text-muted" style="margin: 0 0.75rem;">
            Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-outline btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente ›</a>
        @else
            <span class="btn btn-secondary btn-sm" aria-disabled="true">Siguiente ›</span>
        @endif
    </nav>
@endif
