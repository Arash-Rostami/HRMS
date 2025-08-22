@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span title="no previous" style="cursor: no-drop"
                  class="relative inline-flex items-center px-3 py-1.5 text-white bg-main-mode shadow-lg rounded persol-font hover:opacity-75">
                «
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled"
                    class="relative inline-flex items-center px-3 py-1.5 text-white bg-main-mode shadow-lg rounded persol-font hover:opacity-75">
                «
            </button>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled"
                    class="relative inline-flex items-center px-3 py-1.5 text-white bg-main-mode shadow-lg rounded persol-font hover:opacity-75">

                »
            </button>
        @else
            <span title="no next" style="cursor: no-drop"
                  class="relative inline-flex items-center px-3 py-1.5 text-white bg-main-mode shadow-lg rounded persol-font hover:opacity-75">
                »
            </span>
        @endif
    </nav>
@endif
