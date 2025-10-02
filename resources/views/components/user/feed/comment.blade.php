@php
    $errorMessages = [
        'required' => '',
        'string' => 'نظر باید متن باشد.',
        'characters' => 'نظر نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.'
    ];
@endphp

<details x-data="{ isOpen: false }" :open="isOpen" @click.prevent @class([
    'mt-4 rounded-xl border overflow-hidden',
    'border-gray-400' => !isDarkMode(),
    'border-gray-700' => isDarkMode(),
])>
    <summary class="flex items-center justify-between cursor-pointer select-none px-4 py-3 text-sm font-medium"
             @click="isOpen = !isOpen"
        @class([
            'text-gray-700 bg-gray-50' => !isDarkMode(),
            'text-gray-200 hover:bg-gray-700/60' => isDarkMode(),
        ])>
        <span>نظرات مرتبط با خبر</span>
        <span class="inline-flex items-center gap-2">
            <span class="text-xs opacity-70">({{ $feed->comments_count ?? $feed->comments->count() }})</span>
            <svg class="h-4 w-4 transition-transform" :class="{ '-rotate-180': isOpen }" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
                      clip-rule="evenodd"/>
            </svg>
        </span>
    </summary>
    <div class="px-4 pb-4 pt-2" @click.stop>
        {{--        Adding comment--}}
        <form wire:submit.prevent="addComment({{ $feed->id }})"
              class="flex items-center space-x-2">
            <img class="h-8 w-8 rounded-full object-cover ml-2"
                 src="{{ auth()->user()->profile?->image }}"
                 alt="User avatar">
            <label for="comment-{{ $feed->id }}" class="sr-only">Comment</label>
            <input type="text"
                   id="comment-{{ $feed->id }}"
                   wire:model.defer="newComments.{{ $feed->id }}"
                   placeholder="🖋"
                @class([
                    'w-full text-sm rounded-lg focus:ring-blue-500 block',
                    'border-gray-300 bg-gray-50' => !isDarkMode(),
                    'border-gray-600 bg-gray-800 text-gray-300' => isDarkMode(),
                ])>
            <button wire:click="addComment({{ $feed->id }})"
                    title="نظر خود را به اشتراک بگذارید"
                    class="text-green-500">
                <i class="fa fa-plus text-xs"></i>
            </button>
            @error('newComments.' . $feed->id)
            <span class="text-red-500 text-xs mt-1 block text-right">
                    @php
                        $displayMessage = $message;
                        foreach($errorMessages as $key => $translation) {
                            if (str_contains(strtolower($message), $key)) {
                                $displayMessage = $translation;
                                break;
                            }
                        }
                    @endphp
                {{ $displayMessage }}
                </span>
            @enderror
        </form>

        <div class="mt-4 space-y-4">
            @forelse ($feed->comments as $comment)
                <div class="flex items-start space-x-3">
                    <img class="h-8 w-8 rounded-full object-cover ml-2 cursor-help"
                         title="{{ $comment->user->full_name }}"
                         src="{{ $comment->user->profile?->image }}"
                         alt="{{ $comment->user->full_name }}">

                    <div @class([
                        'flex flex-col flex-1 rounded-lg p-2 text-sm',
                        'bg-gray-100' => !isDarkMode(),
                        'bg-gray-700' => isDarkMode(),
                    ])>
                        <div class="flex justify-between items-center">
                            <span class="text-xs ltr-direction">
                                    <i> {{ $comment->created_at->diffForHumans() }} </i>
                                    <x-heroicon-o-clock class="inline-block h-3 ml-1"/>
                            </span>
                            @if ($comment->user_id === auth()->id())
                                {{--        Editing comment--}}
                                <div x-data
                                     class="flex space-x-2 text-xs">
                                    <button
                                        type="button"
                                        title="نظر خود را ویرایش کنید"
                                        @click="$wire.startEditing({{ $comment->id }})"
                                        class="text-blue-500 ml-1"
                                        @click.stop
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    {{--        Deleting comment--}}
                                    <button
                                        type="button"
                                        title="نظر خود را پاک کنید"
                                        @click="$wire.deleteComment({{ $comment->id }})"
                                        class="text-red-500 mr-1"
                                        @click.stop
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        {{--        Listing comments--}}
                        @if ($editingCommentId === $comment->id)
                            <form wire:submit.prevent="updateComment" class="w-full mt-1">
                                <label for="edit-comment-{{ $comment->id }}" class="sr-only">ویرایش نظر</label>
                                <input
                                    id="edit-comment-{{ $comment->id }}"
                                    type="text"
                                    wire:model.defer="editingContent"
                                    @class([
                                        'w-full text-sm rounded-lg focus:ring-blue-500 block',
                                        'border-gray-300 bg-gray-50' => !isDarkMode(),
                                        'border-gray-600 bg-gray-800 text-gray-300' => isDarkMode(),
                                    ])
                                >
                                @error('editingContent')
                                <span class="text-red-500 text-xs mt-1 block text-right">
                                            @php
                                                $displayMessage = $message;
                                                foreach($errorMessages as $key => $translation) {
                                                    if (str_contains(strtolower($message), $key)) {
                                                        $displayMessage = $translation;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                    {{ $displayMessage }}
                                    </span>
                                @enderror
                                <div class="flex justify-end mt-1 space-x-2">
                                    {{--        Adding comment--}}
                                    <button type="submit"
                                            title="نظر خود را به اشتراک بگذارید"
                                            class="text-green-500 ml-1">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    {{--        Deleting comment--}}
                                    <button type="button"
                                            title="نظر خود را پاک کنید"
                                            wire:click="$set('editingCommentId', null)"
                                            class="text-gray-500 mr-1">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </form>
                        @else
                            <p class="text-right mt-1">{{ $comment->content }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-center"
                    @class([
                        'text-gray-500' => !isDarkMode(),
                        'text-gray-400' => isDarkMode(),
                    ])>
                    هنوز نظری ثبت نشده است.
                </p>
            @endforelse
        </div>
    </div>
</details>
