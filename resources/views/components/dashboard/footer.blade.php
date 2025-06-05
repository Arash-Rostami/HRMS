<div id="footer" class="p-4 text-center flex flex-row mb-6 ignore-elements" x-data>
    @includeWhen(Str::contains(url()->current(), 'dashboard'), 'components.dashboard.audio')
    <x-dashboard.search/>

    <div class="flex flex-col justify-center w-full">
        {{ $slot }}
        <x-dashboard.signature/>
    </div>
</div>



