<div
    x-data="{
        columns: @entangle('columns'),
        dragTask: null,
        updateTaskStatus(taskId, newColumn) {
            $wire.updateTaskStatus(taskId, newColumn);
        }
    }"
    @dragstart.window="dragTask = $event.target.closest('[data-task-id]').dataset.taskId"
    @dragover.window.prevent
    @drop.window="if (dragTask) {
                    const target = $event.target.closest('[data-column]');
                    if (target) updateTaskStatus(dragTask, target.dataset.column);
                    dragTask = null;
                }"
    class="flex flex-col sm:flex-row overflow-x-auto gap-4 p-6 bg-transparent">
    @foreach($columns as $column)
        @php
            $config = $columnConfig[$column];
            $columnTasks = $tasks[$column] ?? [];
            $taskCount = count($columnTasks);
        @endphp
        <div
                @class([
                   'min-w-[320px] flex flex-col rounded-2xl shadow-sm border transition-all duration-300 flex-1',
                   'bg-gray-800 border-gray-700 hover:shadow-lg' => isDarkMode(),
                   'bg-white border-gray-200 hover:shadow-lg' => !isDarkMode(),
               ])
                data-column="{{ $column }}"
                @dragover.prevent
                @drop="if (dragTask) {
                   $wire.updateTaskStatus(dragTask, '{{ $column }}');
                    dragTask = null;
                }">
            {{-- Columns Header --}}
            @include('components.user.tasks.headers')
            {{-- Add Form --}}
            @include('components.user.tasks.form')
            {{-- Tab Switcher --}}
            @include('components.user.tasks.tabs')
            {{-- Tasks Cols (Cards) --}}
            @include('components.user.tasks.cards')
        </div>
    @endforeach
</div>
