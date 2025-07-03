<div x-show="visible"
     x-cloak
     x-transition:enter="transition ease-out duration-400"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="fixed bg-none text-white text-xs rounded py-1 px-2 z-50 shadow-lg"
     :style="{ top: position.y + 'px', left: position.x + 'px' }">
    <div class="relative">
        <div
            class="bg-gradient-to-r from-[var(--main)] via-gray-500 to-[var(--main)] text-white text-sm font-medium rounded-md py-2 px-3">
            <span x-text="text"></span>
        </div>

        <div
            style="border-bottom-color: var(--main);"
            class="absolute -top-2 left-0 translate-x-1/2 translate-y-1/2 border-b-[6px] border-l-[6px] border-r-[6px] border-l-transparent border-r-transparent"></div>
    </div>
</div>
