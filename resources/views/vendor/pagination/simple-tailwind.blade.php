@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span title="no previous" style="cursor: no-drop"
                  class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-[--var('main')] border border-gray-300 cursor-default leading-5 rounded-md">
            <
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" title="<<< previous"
               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[--var('main')] border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" title="next >>>"
               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-[--var('main')] border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                >
            </a>
        @else
            <span title="no next" style="cursor: no-drop"
                  class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-[--var('main')] border border-gray-300 cursor-default leading-5 rounded-md">
                >
            </span>
        @endif
    </nav>
@endif
