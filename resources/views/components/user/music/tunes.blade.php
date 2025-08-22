@inject('music', 'App\Services\Music')

<div class="mx-auto">
    <div class="my-8 md:ml-4">
        <h5 class="text-justify">
            روز کاری‌ رو با موسیقی تمرکز، ورزش یا سرگرمی جذاب‌تر کن :)
        </h5>
    </div>

    @foreach ($music::sortByTheme() as $theme => $themeSongs)
        <div class="card-job links-thumbnails p-5 mb-6 w-4/5 mx-auto">
            <div class="main-color mb-6">{!! $theme !!}</div>

            @foreach(array_chunk($themeSongs, 2) as $songChunk)
                <div class="flex md:flex-row gap-4 mb-4">
                    @foreach($songChunk as $song)
                        <x-user.music.player :song="$song" />
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>
