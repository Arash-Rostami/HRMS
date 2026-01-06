<div class="flex gap-2 p-6 mx-auto">
    <button wire:click="switchTab('my-tasks')"
        @class([
            'text-sm px-6 py-2 rounded-lg font-semibold persol-farsi-font transition',
            'bg-blue-600 text-white' => $activeTab === 'my-tasks',
            'bg-gray-200 text-gray-700 hover:bg-gray-300' => $activeTab !== 'my-tasks'
        ])>
        وظایف من
    </button>
    <button wire:click="switchTab('assigned-tasks')"
        @class([
            'text-sm px-6 py-2 rounded-lg font-semibold persol-farsi-font transition',
            'bg-blue-600 text-white' => $activeTab === 'assigned-tasks',
            'bg-gray-200 text-gray-700 hover:bg-gray-300' => $activeTab !== 'assigned-tasks'
        ])>
        وظایف محول شده
    </button>
</div>
