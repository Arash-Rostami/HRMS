@php
    $emojis = ['👍', '❤️', '😂', '😮', '😢', '💔', '👏'];
    $counts = $feed->reactions->groupBy('emoji')->map->count();
    $userEmoji = $feed->reactions->firstWhere('user_id', auth()->id())?->emoji;
    $dark = isDarkMode();
@endphp

@if (!isset($emojiSplashIncluded))
    @php $emojiSplashIncluded = true; @endphp
    @push('styles')
        <style>
            .emoji-splash-root {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 9999;
                overflow: hidden;
            }

            .emoji-splash {
                position: absolute;
                user-select: none;
                will-change: transform, opacity;
                filter: drop-shadow(0 0 8px currentColor);
                animation: emoji-explode var(--duration, 1500ms) cubic-bezier(.1, .8, .2, 1) var(--delay, 0ms) forwards;
            }

            @keyframes emoji-explode {
                0% {
                    transform: translate(0, 0) scale(1.2) rotate(0);
                    opacity: 1;
                    filter: brightness(1.5) drop-shadow(0 0 12px currentColor);
                }
                15% {
                    transform: translate(calc(var(--tx) * 0.1), calc(var(--ty) * 0.1)) scale(1.4) rotate(calc(var(--r) * 0.1));
                }
                100% {
                    transform: translate(var(--tx), var(--ty)) scale(0) rotate(var(--r));
                    opacity: 0;
                    filter: brightness(0.3) drop-shadow(0 0 0 transparent);
                }
            }

            .reaction-button {
                position: relative;
                transition: all 0.2s cubic-bezier(.2, .9, .2, 1);
            }

            .reaction-button::before {
                content: '';
                position: absolute;
                inset: -4px;
                border-radius: inherit;
                background: radial-gradient(circle, rgba(59, 130, 246, 0.3), transparent 70%);
                opacity: 0;
                transition: opacity 0.3s;
            }

            .reaction-button:hover::before {
                opacity: 1;
                animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            .reaction-button:active {
                transform: scale(0.85);
            }

            .reaction-button.active {
                animation: bounce-in 0.6s cubic-bezier(.68, -0.55, .265, 1.55);
            }

            @keyframes pulse-ring {
                0%, 100% {
                    transform: scale(1);
                    opacity: 0.3;
                }
                50% {
                    transform: scale(1.15);
                    opacity: 0;
                }
            }

            @keyframes bounce-in {
                0% {
                    transform: scale(0.3);
                }
                50% {
                    transform: scale(1.15);
                }
                70% {
                    transform: scale(0.9);
                }
                100% {
                    transform: scale(1);
                }
            }

            .reaction-pill {
                transition: all 0.2s cubic-bezier(.2, .9, .2, 1);
                position: relative;
                overflow: hidden;
            }

            .reaction-pill::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
                opacity: 0;
                transition: opacity 0.3s;
            }

            .reaction-pill:hover::before {
                opacity: 1;
            }

            .reaction-pill:hover {
                transform: translateY(-2px) scale(1.05);
            }

            .emoji-picker {
                backdrop-filter: blur(20px) saturate(180%);
                box-shadow: 0 20px 60px -15px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            }

            .emoji-picker button {
                position: relative;
                transform-style: preserve-3d;
            }

            .emoji-picker button:hover {
                transform: scale(1.2) translateZ(10px);
                filter: brightness(1.3);
            }

            .emoji-picker button:active {
                transform: scale(0.9);
            }
        </style>
    @endpush
@endif

<div
    @class([
        'flex items-center gap-2 py-2 border-t',
        'border-gray-200/80' => !$dark,
        'border-gray-700/80' => $dark,
    ])
    x-data="{
        open: false,
        splash(event, emoji) {
            const root = document.getElementById('emoji-splash-root');
            if (!root) return;

            const { clientX, clientY } = event;
            const count = 25;
            const baseSize = 28;

            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.className = 'emoji-splash';
                p.textContent = emoji;

                const angle = (Math.PI * 2 * i) / count;
                const velocity = 0.4 + Math.random() * 0.6;
                const distance = (window.innerWidth / 2.5) * velocity;

                const tx = Math.cos(angle) * distance * (0.8 + Math.random() * 0.4);
                const ty = Math.sin(angle) * distance * (0.8 + Math.random() * 0.4) - (Math.random() * 100);
                const r = (Math.random() - 0.5) * 1080;
                const size = baseSize * (0.7 + Math.random() * 1.2);
                const left = clientX - (size / 2);
                const top = clientY - (size / 2);
                const duration = 1200 + Math.floor(Math.random() * 600);
                const delay = Math.floor(Math.random() * 80);

                p.style.left = `${left}px`;
                p.style.top = `${top}px`;
                p.style.fontSize = `${size}px`;
                p.style.setProperty('--tx', `${tx}px`);
                p.style.setProperty('--ty', `${ty}px`);
                p.style.setProperty('--r', `${r}deg`);
                p.style.setProperty('--duration', `${duration}ms`);
                p.style.setProperty('--delay', `${delay}ms`);

                p.addEventListener('animationend', () => p.remove(), { once: true });
                root.appendChild(p);
            }

            navigator.vibrate?.(10);
        }
    }"
    x-init="() => {
        if (window.__emojiSplashInitialized) return;
        window.__emojiSplashInitialized = true;
        const rootId = 'emoji-splash-root';
        if (!document.getElementById(rootId)) {
            const root = document.createElement('div');
            root.id = rootId;
            root.className = 'emoji-splash-root';
            root.setAttribute('aria-hidden', 'true');
            document.body.appendChild(root);
        }
    }"
>
    <div class="relative">
        <button
            @click="open = !open"
            type="button"
            title="Add Reaction"
            @class([
                'reaction-button flex items-center justify-center h-10 w-10 rounded-full border-2',
                'bg-gradient-to-br from-slate-100 to-slate-50 border-slate-200 hover:border-slate-300 text-slate-500 hover:shadow-md' => !$dark,
                'bg-gradient-to-br from-slate-800 to-slate-900 border-slate-700 hover:border-slate-600 text-slate-400 hover:shadow-xl hover:shadow-blue-500/20' => $dark,
                'active' => $userEmoji,
            ])
        >
            <span x-show="!open" class="text-xl" x-cloak>+</span>
            <span x-show="open" class="text-xl" x-cloak>×</span>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-75 -translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-75 -translate-y-4"
            @click.outside="open = false"
            @class([
                'emoji-picker absolute bottom-full mb-3 flex items-center gap-2 rounded-full p-2',
                'bg-white/90 border border-gray-200/80' => !$dark,
                'bg-gray-900/90 border border-gray-700/80' => $dark,
            ])
            x-cloak
        >
            @foreach ($emojis as $emoji)
                <button
                    wire:click="toggleReaction({{ $feed->id }}, '{{ $emoji }}')"
                    @click="splash($event, '{{ $emoji }}')"
                    wire:key="react-{{ $feed->id }}-{{ md5($emoji) }}"
                    title="{{ $emoji }}"
                    aria-pressed="{{ $userEmoji === $emoji ? 'true' : 'false' }}"
                    class="reaction-button rounded-full p-2 text-2xl hover:bg-black/5 dark:hover:bg-white/10"
                >
                    {{ $emoji }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="flex items-center flex-wrap gap-2">
        @foreach ($emojis as $emoji)
            @if($count = $counts[$emoji] ?? 0)
                <div @class([
                    'reaction-pill flex items-center gap-1 rounded-full px-3 py-1 text-xs select-none border cursor-default',
                    'bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 text-blue-800 shadow-sm' => !$dark && $userEmoji === $emoji,
                    'bg-gradient-to-br from-slate-100 to-slate-50 border-slate-200 text-slate-700' => !$dark && $userEmoji !== $emoji,
                    'bg-gradient-to-br from-blue-900/50 to-blue-800/50 border-blue-700/50 text-blue-200 shadow-lg shadow-blue-500/20' => $dark && $userEmoji === $emoji,
                    'bg-gradient-to-br from-slate-800 to-slate-900 border-slate-700 text-slate-300' => $dark && $userEmoji !== $emoji,
                ])>
                    <span class="text-base leading-none">{{ $emoji }}</span>
                    <span class="font-semibold tabular-nums">{{ $count }}</span>
                </div>
            @endif
        @endforeach
    </div>
</div>
