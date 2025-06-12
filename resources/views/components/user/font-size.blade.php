@props([
    'returnUrl' => route('user.panel.onboarding'),
])
@php
    $buttons = [
        [
            'action' => 'adjustFontSize(-1)',
            'disabledExpression' => 'currentFontSizeIndex === 0',
            'title' => 'کوچک کردن فونت',
            'icon' => 'search-minus'
        ],
        [
            'action' => 'adjustFontSize(1)',
            'disabledExpression' => 'currentFontSizeIndex === fontSizes.length - 1',
            'title' => 'بزرگ کردن فونت',
            'icon' => 'search-plus'
        ],
        [
            'action' => "window.location.href = '{$returnUrl}'",
            'title' => 'بازگشت به پنل کاربری',
            'icon' => 'redo'
        ]
    ];
@endphp
<div class="flex justify-end gap-3">
    @foreach($buttons as $btn)
        <button
            @click="{{ $btn['action'] }}"
            @isset($btn['disabledExpression']) :disabled="{{ $btn['disabledExpression'] }}" @endisset
            class="bg-main-mode hover:opacity-50 py-1 px-2 rounded transition-opacity {{ isset($btn['disabledExpression']) ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}" {{-- Added disabled styles here --}}
            title="{{ $btn['title'] }}"
        >
            <i class="fas fa-{{ $btn['icon'] }} text-white"></i>
        </button>
    @endforeach
</div>
