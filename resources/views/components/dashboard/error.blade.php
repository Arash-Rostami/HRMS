@foreach ($errors->all() as $error)
    <span class="text-lg">
                    <i class='far fa-frown'></i>
                    {{$error}}
                </span><br>
@endforeach
