@if($feed->content)
    <article dir="rtl"
            @class([
            'leading-snug tracking-wider  text-justify mb-4 p-2',
            'text-gray-800' => !isDarkMode(),
            'text-gray-300' => isDarkMode(),
        ])>
        {!! $feed->content !!}
    </article>
@endif
