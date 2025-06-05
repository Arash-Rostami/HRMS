@if (session()->has('message'))
    <div x-data="{ show: {{ session()->has('message') ? 'true' : 'false' }}}">
        <div class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5" x-show="show"
             x-transition:enter="ease-out duration-600"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-1000" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="max-w-screen-xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="p-3 rounded-lg bg-green-600 shadow-lg sm:p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm leading-5 font-medium text-white">{{ session()->get('message') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-ref="toast" @click="show = false"
                                    x-init="setTimeout(() => {$refs.toast.click()}, 5000)"
                                    class="toast-button inline-flex text-white focus:outline-none focus:shadow-outline-blue transition ease-in-out duration-150">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="white">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011. 414 0L10 8.586l4. 293-4. 293a1 1 0 111. 414 1. 414L11. 414 10l4. 293 4. 293a1 1 0 01-1. 414 1. 414L10 11. 414l-4. 293 4. 293a1 1 0 01-1. 414-1. 414L8. 586 10 4. 293 5.707a1 1 0 010-1. 414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div x-data="{ show: {{ session()->has('error') ? 'true' : 'false' }}}">
        <div class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5" x-show="show"
             x-transition:enter="ease-out duration-600"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-1000" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="max-w-screen-xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="p-3 rounded-lg bg-red-600 shadow-lg sm:p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle"></i>

                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm leading-5 font-medium text-white">{{ session()->get('error') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-ref="toast" @click="show = false"
                                    x-init="setTimeout(() => {$refs.toast.click()}, 5000)"
                                    class="toast-button inline-flex text-white focus:outline-none focus:shadow-outline-blue transition ease-in-out duration-150">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="white">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011. 414 0L10 8.586l4. 293-4. 293a1 1 0 111. 414 1. 414L11. 414 10l4. 293 4. 293a1 1 0 01-1. 414 1. 414L10 11. 414l-4. 293 4. 293a1 1 0 01-1. 414-1. 414L8. 586 10 4. 293 5.707a1 1 0 010-1. 414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

