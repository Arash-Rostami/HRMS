@if($showConfirmDialog)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 animate-[fade-in_0.3s_ease-in-out]"
         wire:click.self="cancelUpload"
         x-data="{ show: @entangle('showConfirmDialog') }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    >
        <div @class([
                    'rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300',
                    'bg-white' => !isDarkMode(),
                    'bg-gray-800' => isDarkMode(),
                ])
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        >
            <div class="text-center">
                <!-- Warning Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
                </div>

                <!-- Title -->
                <h3 @class([
                        'text-xl font-bold mb-4',
                        'text-gray-900' => !isDarkMode(),
                        'text-gray-100' => isDarkMode(),
                    ])>
                    آیا مطمئن هستید؟
                </h3>

                <!-- Warning Message -->
                <p @class([
                'mb-4 leading-relaxed text-sm',
                'text-gray-600' => !isDarkMode(),
                'text-gray-300' => isDarkMode(),
            ])>
                    پس از بارگذاری، امکان حذف یا تغییر فایل وجود نخواهد داشت. این عمل قابل بازگشت نیست.
                </p>

                <!-- File Info Box -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="text-yellow-800 font-semibold text-sm mb-2 flex items-center justify-center">
                        <i class="fas fa-file ml-2"></i>
                        فایل انتخاب شده:
                    </div>
                    <div class="text-yellow-700 text-sm font-medium break-all">
                        {{ $pendingFileName }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-center">
                    <button
                        wire:click="confirmUpload"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-check ml-2"></i>
                        بله، مطمئن هستم
                    </button>
                    <button
                        wire:click="cancelUpload"
                        @class([
                            'font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center',
                            'bg-gray-500 hover:bg-gray-600 text-white' => !isDarkMode(),
                            'bg-gray-600 hover:bg-gray-700 text-gray-200' => isDarkMode(),
                        ])>
                        <i class="fas fa-times ml-2"></i>
                        انصراف
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
