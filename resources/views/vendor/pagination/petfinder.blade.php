@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigation de pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-secondary btn-sm" aria-disabled="true">‹ Précédent</span>
        @else
            <a class="btn btn-outline btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Précédent</a>
        @endif

        <span class="text-muted" style="margin: 0 0.75rem;">
            Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-outline btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant ›</a>
        @else
            <span class="btn btn-secondary btn-sm" aria-disabled="true">Suivant ›</span>
        @endif
    </nav>
@endif
