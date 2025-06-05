@props(['type' => 'info', 'position' => 'top-right'])

@php
    $typeClasses = [
        'info' => 'alert-box',
        'warning' => 'bg-yellow-500 border-yellow-700',
        'error' => 'bg-red-500 border-red-700',
        'success' => 'bg-green-500 border-green-700',
    ][$type];
    $positionClasses = [
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
    ][$position]
@endphp

<div class="{{$positionClasses}} fixed hideAfter5Seconds ignore-elements"
     x-data="{show:true}"
     x-show="show"
     @click="show=false">
    <div class="{{$typeClasses}} max-w-xs text-gray-800 rounded-lg px-4 py-2 slide-in-top">
        <div class="cursor-pointer z-50 float-right ">
            <i class="fas fa-window-close text-gray-900" title="Close"></i>
        </div>
        <br>
        {{$slot}}
    </div>
</div>
