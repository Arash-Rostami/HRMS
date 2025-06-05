<div x-data="{isModalVisible:false}">
    <div x-show="isModalVisible">
        <div x-init="setTimeout(() => isModalVisible=true,2000)"
             class="fixed inset-0 flex items-center justify-center z-50 overflow-x-hidden overflow-y-auto
             outline-none focus:outline-none">
            <div class="relative w-4/5 md:w-1/2 max-w-md p-5 mx-auto my-6 bg-main rounded-lg shadow-xl">
                <!-- Modal content goes here -->
                <div class="text-center">
                    <h2 class="text-2xl font-semibold text-main">{{ $title }}</h2>
                    <p class="mt-2 text-gray-600">{!! $message !!}</p>
                    <p class="mt-2 text-gray-600">🎉🌟🎈🎁🎊🍰</p>
                </div>
                <div class="mt-4 text-center">
                    <button
                        class="px-3 py-1 text-white bg-main-mode rounded focus:outline-none absolute top-1 left-1"
                        title="close me :)" x-on:click="isModalVisible=!isModalVisible;">X
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
