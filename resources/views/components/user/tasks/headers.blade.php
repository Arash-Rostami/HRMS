<div @class([
        'relative overflow-hidden rounded-t-2xl bg-gradient-to-bl p-5',
        $config['darkGradient'] => isDarkMode(),
        $config['lightGradient'] => !isDarkMode(),
    ])>
    <div class="absolute inset-0 bg-black/5"></div>
    <div class="relative flex items-center justify-between text-white">
        <div class="flex items-center gap-3">
            <span class="text-2xl font-bold">{{ $config['icon'] }}</span>
            <div>
                <h3 class="font-bold text-lg persol-farsi-font">{{ $config['title'] }}</h3>
                <p class="text-xs opacity-90 mt-0.5 persol-farsi-font">
                    {{ $taskCount }} وظیفه
                </p>
            </div>
        </div>
        @if($column === 'todo')
            <button wire:click="createTask"
                    type="button"
                    class="w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-200 flex items-center justify-center group"
                    title="افزودن وظیفه">
                <span class="text-2xl font-light leading-none group-hover:rotate-90 transition-transform duration-200">
                    ✚
                </span>
            </button>
        @endif
    </div>
</div>
