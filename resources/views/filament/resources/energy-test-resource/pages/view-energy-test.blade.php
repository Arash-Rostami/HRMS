<x-filament::page>
    <div class="space-y-8">
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-gray-500 dark:text-gray-400">
                Completed on: {{ $record->completed_at->format('F d, Y') }} ( {{ toJalali($record->completed_at) }} )
                <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $record->completed_at->format('H:i') }}
            </p>
            <div class="grid grid-cols-2 mt-4 text-center md:grid-cols-5 gap-4">
                @foreach(['overall' => 'Overall', 'mind' => 'Mind', 'emotion' => 'Emotion', 'physique' => 'Physique', 'soul' => 'Soul'] as $key => $label)
                    <div class="p-3 border rounded-lg dark:border-gray-700">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</div>
                        <div class="text-2xl font-bold">{{ $record->{$key . '_score'} }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @foreach($questions as $category => $categoryQuestions)
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800" dir="rtl">
                <h1 class="font-semibold leading-tight mb-3">{{ $sections[$category] ?? '' }}</h1>
                <div class="space-y-3">
                    @foreach($categoryQuestions as $index => $questionText)
                        @php $answered = $record->answers[$category][$index] ?? false; @endphp
                        <div
                            class="flex items-center p-3 rounded-md border-2 {{ $answered ? 'border-primary-600 dark:border-primary-400' : 'border-gray-300 dark:border-gray-700' }}">
                            @if($answered)
                                <x-heroicon-s-check-circle class="w-5 h-5 ml-3 text-primary-600 dark:text-primary-400"/>
                            @else
                                <x-heroicon-o-x-circle class="w-5 h-5 ml-3 text-gray-400 dark:text-gray-500"/>
                            @endif
                            <span
                                class="{{ $answered ? 'font-medium text-gray-800 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">{{ $questionText }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-filament::page>
