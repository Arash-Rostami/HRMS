@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <ul class="mt-3 list-disc list-inside text-sm main-color">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
