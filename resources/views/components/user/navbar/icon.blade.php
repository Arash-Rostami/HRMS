@props([
    'href',
    'icon',
    'label',
    'tooltip'
])

<div @class([
        'flex flex-col items-center text-center relative',
         'ml-4' => $icon == 'fas fa-cogs'
      ])>
    <a {{ $attributes->merge([
      'href'  => $href,
      'class' => 'text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110'
    ]) }}
       @mouseenter="window.innerWidth > 768 && showTooltip('{{ $tooltip }}', $event)"
       @mouseleave="hideTooltip()"
    >
        <i class="{{ $icon }}"></i>
    </a>

    {{ $slot }}

    <span @class([
        'mt-1 text-sm text-gray-700',
        'text-gray-300 ' => isDarkMode(),
    ])>{{ $label }}</span>
</div>
