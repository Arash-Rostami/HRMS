@php $dark = (Cookie::get('mode') == '#F1F1F1');@endphp
<a
@if($dark)
    {{ $attributes->merge(['class' => 'hover:z-50 block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-300 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>

@else
    {{ $attributes->merge(['class' => 'hover:z-50 block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-800 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
@endif

