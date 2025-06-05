@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm main-color']) }}>
        {{ $status }}
    </div>
@endif
