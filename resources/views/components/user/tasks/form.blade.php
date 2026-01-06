@if($column === 'todo')
    <div class='p-4 border-b rounded links-thumbnails links-thumbnails-color bg-weekend rtl-direction'>
        <div class="space-y-3 p-2">
            <div class="relative py-2" dir="rtl">
                <input
                    id="newTitle"
                    wire:model.defer="newTitle"
                    placeholder=" "
                    @class([
                        'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font placeholder-transparent',
                        'focus:ring-'.$config['color'].'-500' => true,
                        'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                        'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                    ])
                />
                <label for="newTitle"
                       class="absolute right-2 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                              peer-placeholder-shown:scale-100
                              peer-placeholder-shown:top-1/2
                              peer-placeholder-shown:-translate-y-1/2
                              peer-placeholder-shown:text-gray-500
                              peer-focus:scale-75
                              peer-focus:-top-2.5
                              peer-focus:-translate-y-1/2
                              peer-focus:text-{{$config['color']}}-600
                              peer-focus:px-2
                              peer-[&:not(:placeholder-shown)]:scale-75
                              peer-[&:not(:placeholder-shown)]:-top-2.5
                              peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                              peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                              peer-[&:not(:placeholder-shown)]:px-2
                              peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                              ">
                    عنوان وظیفه
                </label>
                @error('newTitle')
                <span class="text-rose-500 text-xs persol-farsi-font flex items-center gap-1 mt-1">
                    <span>⚠</span>{{ $message }}
                </span>
                @enderror
            </div>
            <div class="relative py-2" dir="rtl">
                <textarea
                    id="newDescription"
                    wire:model.defer="newDescription"
                    placeholder=" "
                    rows="2"
                    @class([
                        'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font placeholder-transparent ',
                        'focus:ring-'.$config['color'].'-500' => true,
                        'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                        'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                    ])
                ></textarea>
                <label for="newDescription"
                       class="absolute right-2 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                              peer-placeholder-shown:scale-100
                              peer-placeholder-shown:top-1/2
                              peer-placeholder-shown:-translate-y-1/2
                              peer-placeholder-shown:text-gray-500
                              peer-focus:scale-75
                              peer-focus:-top-2.5
                              peer-focus:-translate-y-1/2
                              peer-focus:text-{{$config['color']}}-600
                              peer-focus:px-2
                              peer-[&:not(:placeholder-shown)]:scale-75
                              peer-[&:not(:placeholder-shown)]:-top-2.5
                              peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                              peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                              peer-[&:not(:placeholder-shown)]:px-2
                              peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                              ">
                    توضیحات (اختیاری)
                </label>
            </div>
            <div dir="rtl">
                <span class="text-sm"> مهلت انجام (اختیاری)</span>
                <div class="grid grid-cols-3 gap-2">
                    <div class="relative py-2" dir="rtl">
                        <select
                            id="deadlineYear"
                            wire:model.defer="deadlineYear"
                            @class([
                                'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font ',
                                'focus:ring-'.$config['color'].'-500' => true,
                                'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                                'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                            ])
                        >
                            <option value=""></option>
                            @foreach($years as $year)
                                <option class="justify-center" value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <label for="deadlineYear"
                               class="absolute right-1/3 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                                      peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:top-1/2
                                      peer-placeholder-shown:-translate-y-1/2
                                      peer-placeholder-shown:text-gray-500
                                      peer-focus:scale-75
                                      peer-focus:top-10
                                      peer-focus:-translate-y-1/2
                                      peer-focus:text-{{$config['color']}}-600
                                      peer-focus:px-2
                                      peer-[&:not(:placeholder-shown)]:scale-75
                                      peer-[&:not(:placeholder-shown)]:-top-2.5
                                      peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                                      peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                                      peer-[&:not(:placeholder-shown)]:px-2
                                      peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                                      ">
                            سال
                        </label>
                    </div>
                    <div class="relative py-2" dir="rtl">
                        <select
                            id="deadlineMonth"
                            wire:model.defer="deadlineMonth"
                            @class([
                                'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font ',
                                'focus:ring-'.$config['color'].'-500' => true,
                                'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                                'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                            ])
                        >
                            <option value=""></option>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="deadlineMonth"
                               class="absolute right-1/3 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                                      peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:top-1/2
                                      peer-placeholder-shown:-translate-y-1/2
                                      peer-placeholder-shown:text-gray-500
                                      peer-focus:scale-75
                                      peer-focus:top-10
                                      peer-focus:-translate-y-1/2
                                      peer-focus:text-{{$config['color']}}-600
                                      peer-focus:px-2
                                      peer-[&:not(:placeholder-shown)]:scale-75
                                      peer-[&:not(:placeholder-shown)]:-top-2.5
                                      peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                                      peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                                      peer-[&:not(:placeholder-shown)]:px-2
                                      peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                                      ">
                            ماه
                        </label>
                    </div>
                    <div class="relative py-2" dir="rtl">
                        <select
                            id="deadlineDay"
                            wire:model.defer="deadlineDay"
                            @class([
                                'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font ',
                                'focus:ring-'.$config['color'].'-500' => true,
                                'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                                'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                            ])
                        >
                            <option value=""></option>
                            @for($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <label for="deadlineDay"
                               class="absolute right-1/3 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                                      peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:top-1/2
                                      peer-placeholder-shown:-translate-y-1/2
                                      peer-placeholder-shown:text-gray-500
                                      peer-focus:scale-75
                                      peer-focus:top-10
                                      peer-focus:-translate-y-1/2
                                      peer-focus:text-{{$config['color']}}-600
                                      peer-focus:px-2
                                      peer-[&:not(:placeholder-shown)]:scale-75
                                      peer-[&:not(:placeholder-shown)]:-top-2.5
                                      peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                                      peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                                      peer-[&:not(:placeholder-shown)]:px-2
                                      peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                                      ">
                            روز
                        </label>
                    </div>
                </div>
                @error('deadline')
                <span
                    class="text-rose-500 text-xs persol-farsi-font flex items-center gap-1 mt-1"><span>⚠</span>{{ $message }}</span>
                @enderror
            </div>
            @if($column === 'todo')
                <div class="relative py-2" dir="rtl">
                    <select
                        id="selectedAssignee"
                        wire:model.defer="selectedAssignee"
                        @class([
                            'peer block w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:outline-none focus:border-transparent transition-all persol-farsi-font text-center',
                            'focus:ring-'.$config['color'].'-500' => true,
                            'border-gray-600 bg-gray-800 text-gray-100' => isDarkMode(),
                            'border-gray-300 bg-white text-gray-900' => !isDarkMode(),
                        ])>
                        <option value=""></option>
                        @foreach(collect([['id' => '', 'full_name' => 'خودم']])->merge($staffMembers) as $staff)
                            <option value="{{ $staff['id'] }}">{{ $staff['full_name'] }}</option>
                        @endforeach

                    </select>
                    <label for="selectedAssignee"
                           class="absolute right-8 start-4 top-1/2 -translate-y-1/2 scale-100 text-sm pointer-events-none transition-all duration-300 origin-start persol-farsi-font
                      peer-placeholder-shown:scale-100
                      peer-placeholder-shown:top-1/2
                      peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:text-gray-500
                      peer-focus:scale-75
                      peer-focus:top-10
                      peer-focus:-translate-y-1/2
                      peer-focus:text-{{$config['color']}}-600
                      peer-focus:px-2
                      peer-[&:not(:placeholder-shown)]:scale-75
                      peer-[&:not(:placeholder-shown)]:-top-2.5
                      peer-[&:not(:placeholder-shown)]:-translate-y-1/2
                      peer-[&:not(:placeholder-shown)]:text-{{$config['color']}}-600
                      peer-[&:not(:placeholder-shown)]:px-2
                      peer-[&:not(:placeholder-shown)]:bg-{{ isDarkMode() ? 'gray-800' : 'white' }}
                      ">
                        محول به
                    </label>
                </div>
            @endif
        </div>
    </div>
@endif
