<table class="min-w-full border-collapse block sm:table links-thumbnails shadow-2xl table-auto overflow-scroll">
    <thead class="p-6">
    <tr class="px-2 p-6 bg-main">
        <th class="text-center py-2 px-3 ">
            عنوان
        </th>
        <th class="text-center py-2 px-3 ">
            توضیحات
        </th>
        <th class="text-center py-2 px-3 ">
            بخش
        </th>
        <th class="text-center py-2 px-3 ">
            ارسال کننده
        </th>
        <th class="text-center py-2 px-3 ">
            وضعیت
        </th>
        <th class="text-center py-2 px-3 ">
            پرشده شخصی
        </th>
        <th class="text-center py-2 px-3 ">
            پیوست
        </th>
        <th class="text-center py-2 px-3 cursor-pointer ">
            لغو
        </th>
    </tr>
    </thead>
    <tbody class="px-8">
    @foreach($suggestions as $record)
        <tr class="py-4">
            <td class="text-right pr-4">{{ showFewFirstPersians($record->title,6) }}</td>
            <td class="text-right py-4 px-3">{{ showFewFirstPersians($record->description, 8) }}</td>
            <td class="text-center py-8 px-3">
                @unless(is_null($record->reviews ))
                    @foreach($record->reviews as $review)
                        <div class="flex flex-row">
                            <div class="w-[15%]" title="opinion">{{ $review->feedbackIcon() }} </div>
                            <div class="w-[70%] bg-main text-center @if($loop->first) text-main @endif">
                                {{ $deps[$review->department] ?? '-' }}
                            </div>
                            <div class="w-[15%] cursor-pointer" title="view comments"> {{  '📋'  }} </div>
                        </div>
                    @endforeach
                @else
                    <span class="text-center"> تعیین نشده است</span><br>
                @endunless
            </td>
            <td class="text-right py-4 px-3 opacity-50">{{ $record->user->forenameInitials }}</td>
            <td class="text-center py-4 px-3">{{ $record->stageIcon() }}</td>
            <td class="text-center px-1">{{ $record->self_fill ? '✔️' : '❌' }}</td>
            <td class="text-center px-1">
                @if(!empty($record->attachment))
                    <a href="{{ $record->attachment }}" target="_blank" title="click to view">👁️</a>
                @else
                    <span title="nothing to view">🚫</span>
                @endif
            </td>
            <td class="text-center px-1 pl-4">{{ $record->abort == 'yes' ? '✔️' : '❌' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="suggestion-links p-2 mt-2">
    {{ $suggestions->links() }}
</div>
