<div class="p-4 space-y-3 flex-1 overflow-y-auto">
    @if($taskCount > 0)
        @foreach($tasks[$column] ?? [] as $task)
            <div
                wire:key="task-{{ $task['id'] }}-{{ $activeTab }}"
                x-data="{ descriptionOpen: false }"
                title="{{ ($task['deadline'] && new \Carbon\Carbon($task['deadline']) < now()) ? 'با تاخیر' : '' }}"
                draggable="{{ $task['can_change_status'] ? 'true' : 'false' }}"
                @dragstart="if ({{ $task['can_change_status'] ? 'true' : 'false' }}) dragTask = {{ $task['id'] }}"
                data-task-id="{{ $task['id'] }}"
                @click="$wire.editTask({{ $task['id'] }})"
                class="relative group p-4 rounded-xl shadow-sm border hover:shadow-md hover:scale-[1.02] cursor-grab active:cursor-grabbing transition-all duration-200 links-thumbnails links-thumbnails-color bg-weekend">
                {{--Delete card--}}
                @if($activeTab === 'my-tasks' && $task['can_delete'])
                    <button
                        type="button"
                        title="حذف وظیفه"
                        @click="if(confirm('آیا از حذف این وظیفه اطمینان دارید؟')) { @this.call('deleteTask', {{ $task['id'] }}) }"
                        @class([
                            'absolute -top-2 -right-2 w-7 h-7 rounded-lg shadow-sm border backdrop-blur-sm flex items-center justify-center transition-all opacity-0 group-hover:opacity-100',
                            isDarkMode()
                                ? 'bg-gray-800/80 border-gray-700 text-red-400 hover:bg-red-500/20 hover:text-red-300'
                                : 'bg-white/80 border-gray-300 text-red-500 hover:bg-red-50 hover:text-red-600'
                        ])>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </span>
                    </button>
                @endif
                {{--Deadline badge--}}
                @if($task['deadline'])
                    <div
                        @class([
                            'absolute -top-2 -left-2 flex items-center gap-1.5 px-2.5 py-1 rounded-lg shadow-sm border backdrop-blur-sm',
                            (isDarkMode() ? 'bg-red-500/90 border-red-400' : 'bg-red-500 border-red-600') . ' text-white' => $task['deadline'] && new \Carbon\Carbon($task['deadline']) < now(),
                            (isDarkMode() ? 'bg-' . $config['color'] . '-500/90 border-' . $config['color'] . '-400' : 'bg-' . $config['color'] . '-500 border-' . $config['color'] . '-600') . ' text-white' => !$task['deadline'] || new \Carbon\Carbon($task['deadline']) >= now()
                        ])>
                        <span class="text-[10px]">⏰</span>
                        <span class="text-[10px]">مهلت:</span>
                        <span class="text-[10px] font-semibold persol-farsi-font">
                            {{ $task['deadline_formatted'] }}
                        </span>
                    </div>
                @endif

                {{--Card --}}
                <div class="mt-2">
                    {{--Title --}}
                    <h4
                        @class([
                            'font-semibold text-sm persol-farsi-font leading-relaxed mb-3',
                            'text-gray-100' => isDarkMode(),
                            'text-gray-900' => !isDarkMode(),
                        ])>
                        {{ $task['title'] }}
                    </h4>
                    {{--Description --}}
                    @if(!empty($task['description']))
                        @php($clean = e(strip_tags($task['description'])))
                        <div class="mb-3"
                             x-data="{
                                descriptionOpen: false,
                                needsTruncation: {{ mb_strlen($clean) > 100 ? 'true' : 'false' }},
                                truncatedText: @js(Str::limit($clean, 100, '...')),
                                fullText: @js($clean)
                            }">
                            <p @class([
                                    'text-xs leading-relaxed persol-farsi-font',
                                    'text-gray-400' => isDarkMode(),
                                    'text-gray-600' => !isDarkMode(),
                                ])
                               x-text="descriptionOpen ? fullText : truncatedText">
                            </p>
                            <template x-if="needsTruncation">
                                <button
                                    @click.stop="descriptionOpen = !descriptionOpen"
                                    type="button"
                                    @class([
                                        'text-xs font-semibold persol-farsi-font mt-1',
                                        'text-blue-400 hover:text-blue-300' => isDarkMode(),
                                        'text-blue-600 hover:text-blue-500' => !isDarkMode(),
                                    ])>
                                    <span x-show="!descriptionOpen">بیشتر...</span>
                                    <span x-show="descriptionOpen" x-cloak>کمتر</span>
                                </button>
                            </template>
                        </div>
                    @endif
                    {{--Assignee & Delegator --}}
                    @if($activeTab === 'my-tasks')
                        @if($task['assignee_name'] && $task['user_id'] !== auth()->id())
                            <div title="محوله از"
                                @class([
                                'flex items-center gap-2 p-2 rounded-lg mb-3 cursor-pointer',
                                'bg-main' => !isDarkMode(),
                                'bg-[#1F2937]' => isDarkMode(),
                            ])>
                                <div class="flex flex-col flex-1">
                                    <span class="text-[10px] font-medium persol-farsi-font">
                                      <span class="text-sm">↙️</span>
                                       <span class="text-sm">🙍🏻‍♂️</span>
                                          <span class="text-xs font-semibold persol-farsi-font">
                                                 {{ $task['delegator_name'] }}
                                          </span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    @elseif($activeTab === 'assigned-tasks')
                        @if($task['assignee_name'])
                            <div
                                title="محوله به"
                                @class([
                                'flex items-center gap-2 p-2 rounded-lg mb-3 cursor-pointer',
                                'bg-main' => !isDarkMode(),
                                'bg-[#1F2937]' => isDarkMode(),
                            ])>
                                <div class="flex flex-col flex-1">
                                    <span class="text-[10px] font-medium persol-farsi-font">
                                      <span class="text-sm">↗️</span>
                                       <span class="text-sm">🙍🏻‍♂️</span>
                                        <span class="text-xs font-semibold persol-farsi-font">
                                            {{ $task['assignee_name'] }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endif
                    {{--Undo --}}
                    @if($task['is_delegator'] && $column !== 'done')
                        <button
                            @click.stop="$wire.undoAssignment({{ $task['id'] }})"
                            type="button"
                            @class([
                                'w-full flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold persol-farsi-font transition-all mb-3',
                                'bg-amber-500/20 text-amber-400 hover:bg-amber-500/30 border border-amber-500/30' => isDarkMode(),
                                'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' => !isDarkMode(),
                            ])>
                            <span>↩️</span>
                            <span>لغو محول کردن</span>
                        </button>
                    @endif
                    {{--Footer --}}
                    <div @class([
                            'flex items-center justify-between pt-3 border-t text-[10px]',
                            'border-gray-700 text-gray-500' => isDarkMode(),
                            'border-gray-200 text-gray-400' => !isDarkMode(),
                        ])>
                        <span class="persol-farsi-font">شناسه: #<span>{{ $task['id'] }}</span></span>
                        <span class="persol-farsi-font">ایجاد شده: {{ $task['created_formatted'] }}</span>
                        @if($task['is_delegator'])
                            <span class="persol-farsi-font text-amber-500">✓ محول شده </span>
                        @else
                            <span class="persol-farsi-font">{{ $config['title'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{--Paginators --}}
        @if(!empty($tasks[$column]))
            <div class="flex justify-between mt-2">
                {{--Before paginator --}}
                @if(($page[$column] ?? 1) > 1)
                    <button
                        title="قبلی ها"
                        wire:click="prevPage('{{ $column }}')"
                        type="button"
                        @class([
                            'w-1/2 py-3 mr-1 rounded-xl border-2 border-dashed transition-all duration-200 persol-farsi-font text-sm font-medium',
                            isDarkMode()
                                ? 'border-gray-600 text-gray-400 hover:border-gray-500 hover:bg-gray-700/50'
                                : 'border-gray-300 text-gray-500 hover:border-gray-400 hover:bg-gray-50'
                        ])>
                        «
                    </button>
                @else
                    <div class="w-1/2 mr-1"></div>
                @endif

                {{--After paginator--}}
                @if(count($tasks[$column]) >= $perPage)
                    <button
                        title=" بعدی ها"
                        wire:click="nextPage('{{ $column }}')"
                        type="button"
                        @class([
                            'w-1/2 py-3 ml-1 rounded-xl border-2 border-dashed transition-all duration-200 persol-farsi-font text-sm font-medium',
                            isDarkMode()
                                ? 'border-gray-600 text-gray-400 hover:border-gray-500 hover:bg-gray-700/50'
                                : 'border-gray-300 text-gray-500 hover:border-gray-400 hover:bg-gray-50'
                        ])>
                        »
                    </button>
                @else
                    <div class="w-1/2 ml-1"></div>
                @endif
            </div>
        @endif
    @else
        {{--Empty Placeholder --}}
        <div @class([
                'flex flex-col items-center justify-center py-12',
                'text-gray-600' => isDarkMode(),
                'text-gray-400' => !isDarkMode(),
            ])>
            <div @class([
                    'w-16 h-16 rounded-2xl flex items-center justify-center mb-3',
                    'bg-gray-700' => isDarkMode(),
                    'bg-gray-100' => !isDarkMode(),
                ])>
                <span class="text-3xl">📭</span>
            </div>
            <p class="text-sm font-medium persol-farsi-font">هیچ وظیفه‌ای وجود ندارد</p>
        </div>
    @endif
    {{--Dropbox for Tasks --}}
    <div @class([
            'border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200 hover:border-' . $config['color'] . '-400',
            'border-gray-600 text-gray-500 hover:bg-' . $config['color'] . '-900/10' => isDarkMode(),
            'border-gray-300 text-gray-400 hover:bg-' . $config['color'] . '-50' => !isDarkMode(),
        ])>
        <span class="text-lg block mb-2">↓</span>
        <span class="text-sm persol-farsi-font">رها کنید اینجا</span>
    </div>
</div>
