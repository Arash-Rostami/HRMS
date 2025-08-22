@php
    $thClass = 'py-2 px-4 border-b';
    $tdBase = 'py-2 px-4 border-b border-dotted border-b-main cursor-help';

    $headers = [
        ['icon' => 'fas fa-ticket-alt',      'label' => 'شناسه تیکت', 'visible' => 'hidden md:table-cell'],
        ['icon' => 'fas fa-info-circle',     'label' => 'وضعیت','visible' => ''],
        ['icon' => 'fas fa-layer-group',     'label' => 'حوزه درخواست','visible' => ''],
        ['icon' => 'fas fa-tag',             'label' => 'موضوع','visible' => 'hidden md:table-cell'],
        ['icon' => 'fas fa-user-check',      'label' => 'مسئول','visible' => 'hidden md:table-cell'],
        ['icon' => 'fas fa-star',            'label' => 'رضایت','visible' => 'hidden md:table-cell'],
        ['icon' => 'fas fa-calendar-check',  'label' => 'تاریخ تکمیل','visible' => 'hidden md:table-cell']
    ];

    $priorityMap = [
        'low'    => ['color'=>'text-green-500','title'=>'اولویت پایین'],
        'medium' => ['color'=>'text-yellow-500','title'=>'اولویت متوسط'],
        'high'   => ['color'=>'text-red-500','title'=>'اولویت بالا'],
    ];
    $statusMap = [
        'open'        => ['icon'=>'fas fa-circle','color'=>'text-green-500 animate-pulse','title'=>'ارسال شده'],
        'in-progress' => ['icon'=>'fas fa-spinner','color'=>'text-yellow-500 animate-spin','title'=>'در حال بررسی'],
        'closed'      => ['icon'=>'fas fa-check-circle','color'=>'text-gray-500','title'=>'بسته شده'],
    ];
@endphp

<div class="overflow-x-auto rounded-lg shadow-md ticket-div @if(isDarkMode()) hover:bg-gray-900/20 @else hover:bg-gray-200  @endif">
    <table class="ticket-table min-w-full">
        <thead class="bg-gray-400 text-gray-700 text-right">
        <tr>
            @foreach($headers as $h)
                <th class="{{ $thClass }} {{ $h['visible'] }}">
                    <i class="{{ $h['icon'] }} ml-1"></i>
                    {{ $h['label'] }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            @php
                $prio   = $priorityMap[$ticket->priority] ?? null;
                $stat   = $statusMap[$ticket->status] ?? null;
                $fId    = 'PS-T-' . $ticket->created_at->format('Y-m') . '-' . str_pad($ticket->id,4,'0',STR_PAD_LEFT);
                $subj   = Str::limit($ticket->request_subject, 50);
                $descr  = Str::limit($ticket->description,     50);
            @endphp

            <tr @class([
                        'hover:bg-gray-900/20' => isDarkMode(),
                        'hover:bg-gray-200'    => !isDarkMode(),
                    ])>
                {{-- Priority + ID --}}
                <td class="py-2 px-4 flex items-center cursor-help hidden lg:table-cell">
                    @if($prio)
                        <i class="fas fa-exclamation-triangle {{ $prio['color'] }} ml-2"
                           title="{{ $prio['title'] }}"></i>
                    @endif
                    <span class="ltr-direction" title="{{ $ticket->created_at->diffForHumans() }}">
                            {{ $fId }}
                        </span>
                </td>

                {{-- Status --}}
                <td class="py-2 px-4 items-center cursor-help" title="{{ ucfirst($ticket->status) }}">
                    @if($stat)
                        <i class="{{ $stat['icon'] }} {{ $stat['color'] }}" title="{{ $stat['title'] }}"></i>
                    @endif
                </td>

                {{-- Request area --}}
                <td class="{{ $tdBase }}" title="{{ ucfirst($ticket->request_type) }}">
                    {{ $ticket->getRequestAreaOptions($ticket->request_type, $ticket->request_area) }}
                </td>

                {{-- Subject & tooltip description --}}
                <td class="{{ $tdBase }} hidden lg:table-cell" title="{{ $descr }}">
                    {{ $subj }}
                </td>

                {{-- Assignee --}}
                <td class="{{ $tdBase }} hidden lg:table-cell">
                    {{ $ticket->assignee->full_name ?? 'در انتظار' }}
                </td>

                {{-- Satisfaction stars --}}
                <td class="{{ $tdBase }} hidden lg:table-cell">
                    {!! str_repeat('✮', number_format($ticket->satisfaction_score, 0)) !!}
                </td>

                {{-- Completion date --}}
                <td @class([
                            "$tdBase ltr-direction hidden lg:table-cell",
                            'text-green-500' => $ticket->completion_date,
                            'text-gray-500'  => !$ticket->completion_date,
                        ])
                    title="{{ optional($ticket->completion_date)->diffForHumans() ?? 'در صف انتظار' }}">
                    {{ optional($ticket->completion_date)->diffForHumans() ?? 'در صف انتظار' }}
                </td>

                {{-- Actions --}}
                <td class="py-2 px-4 text-center" title="مشاهده بیشتر">
                    <button class="bg-main-mode text-white px-3 py-1 rounded hover:bg-blue-600"
                            wire:click="viewTicket({{ $ticket->id }})">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="rounded-xl px-3" dir="ltr">
    <div class="mt-4"
         x-data="{
            applyTheme() {
              this.$el.querySelectorAll('button, span span')
                .forEach(el => el.classList.add('bg-main-mode', 'text-main-theme'));
            }
          }"
         x-init="applyTheme()"
         x-effect="applyTheme()"
    >
        {{ $tickets->links('vendor.livewire.simple-tailwind') }}
    </div>
</div>
@include('components.user.ths.tab-modal')


