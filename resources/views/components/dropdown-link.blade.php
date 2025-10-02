@php $dark = (Cookie::get('mode') == '#F1F1F1');@endphp
<a
@if($dark)
    {{ $attributes->merge(['class' => 'hover:z-[10000000] block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-red-500 focus:outline-none transition duration-150 ease-in-out']) }}>{{ $slot }}</a>

@else
    {{ $attributes->merge(['class' => 'hover:z-[10000000] block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-red-500 focus:outline-none  transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
@endif

