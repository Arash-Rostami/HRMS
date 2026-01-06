@if($feed->content)
    <article dir="rtl"
        @class([
        'leading-snug tracking-wider text-justify mb-4 p-2',
        'text-gray-800' => !isDarkMode(),
        'text-gray-300' => isDarkMode(),
    ])>
        {!! $feed->content !!}
    </article>
    @push('scripts')
        <script>
            document.querySelectorAll('[style*="text-decoration"][style*="underline"], u, .underline').forEach(el => {
                el.classList.add('cursor-pointer');
                el.title = 'برای باز کردن کلیک کنید';

                el.addEventListener('click', function () {
                    const text = this.textContent.trim();
                    if (text.startsWith('http') || text.startsWith('www')) {
                        window.open(text.startsWith('http') ? text : 'https://' + text, '_blank');
                    }
                });
            });
        </script>
    @endpush
@endif
