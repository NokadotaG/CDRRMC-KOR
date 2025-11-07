@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-end align-items-center my-2" style="gap: 3px; font-size: 0.8rem;">
            
            {{-- First Page --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a href="{{ $paginator->url(1) }}" class="page-link px-2 py-1">&laquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link px-2 py-1">&laquo;</span></li>
            @endif

            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link px-2 py-1">&lsaquo;</span></li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link px-2 py-1" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Current Page --}}
            <li class="page-item active">
                <span class="page-link px-2 py-1">{{ $paginator->currentPage() }}</span>
            </li>

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link px-2 py-1" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link px-2 py-1">&rsaquo;</span></li>
            @endif

            {{-- Last Page --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link px-2 py-1">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link px-2 py-1">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
