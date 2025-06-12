@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span title="no previous" style="cursor: no-drop"
                  class="relative inline-flex items-center px-3 py-1 text-white bg-main-mode shadow-lg rounded persol-font hover:opacity-75">
            «
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" title="<< previous"
               class="relative inline-flex items-center px-3 py-1 text-white bg-main-mode p-2 md:px-2 md:py-1 shadow-lg rounded persol-font hover:opacity-75">
                «
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" title="next >>"
               class="relative inline-flex items-center px-3 py-1 text-white bg-main-mode p-2 shadow-lg rounded persol-font hover:opacity-75">
                »
            </a>
        @else
            <span title="no next" style="cursor: no-drop"
                  class="relative inline-flex items-center px-3 py-1 text-white bg-main-mode p-2 shadow-lg rounded persol-font hover:opacity-75">
                »
            </span>
        @endif
    </nav>
@endif
