<div class="overflow-x-auto rounded-lg shadow-md ticket-div">
    <table class="ticket-table min-w-full">
        <thead class="bg-gray-400 text-gray-700 text-right">
        <tr>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-ticket-alt text-center ml-1"></i>
                شناسه تیکت
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-info-circle ml-1"></i>
                وضعیت
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-layer-group ml-1"></i>
                حوزه درخواست
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-tag ml-1"></i>
                موضوع
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-user-check ml-1"></i>
                مسئول
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-star ml-1"></i>
                رضایت
            </th>
            <th class="py-2 px-4 border-b">
                <i class="fas fa-calendar-check ml-1"></i>
                تاریخ تکمیل
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr class="@if(isDarkMode()) hover:bg-gray-900/20 @else hover:bg-gray-200  @endif">
                <td class="py-2 px-4 flex items-center cursor-help">
                    @if($ticket->priority === 'low')
                        <i class="fas fa-exclamation-triangle text-green-500 ml-2" title="Low Priority"></i>
                    @elseif($ticket->priority === 'medium')
                        <i class="fas fa-exclamation-triangle text-yellow-500 ml-2" title="Medium Priority"></i>
                    @elseif($ticket->priority === 'high')
                        <i class="fas fa-exclamation-triangle text-red-500 ml-2" title="High Priority"></i>
                    @endif
                    <!-- Ticket ID -->
                    <span class="ltr-direction" title=" {{ $ticket->created_at->diffForHumans() }}">
                        PS-T-{{ $ticket->created_at->format('Y-m') }}-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </td>
                <td class="py-2 px-4 items-center cursor-help" title="{{ ucfirst($ticket->status) }}">
                    @if($ticket->status === 'open')
                        <i class="fas fa-circle text-green-500 animate-pulse" title="Open"></i>
                    @elseif($ticket->status === 'in-progress')
                        <i class="fas fa-spinner text-yellow-500 animate-spin" title="In Progress"></i>
                    @elseif($ticket->status === 'closed')
                        <i class="fas fa-check-circle text-gray-500" title="Closed"></i>
                    @endif
                </td>
                <td class="py-2 px-4 border-b border-dotted border-b-main cursor-help"
                    title=" {{ ucfirst($ticket->request_type) }}">
                    {{ $ticket->getRequestAreaOptions($ticket->request_type, $ticket->request_area) }}
                </td>
                <td class="py-2 px-4 border-b border-dotted border-b-main cursor-help"
                    title="{{  Str::limit($ticket->description, 50) }}">{{ Str::limit($ticket->request_subject, 50) }}
                </td>
                <td class="py-2 px-4 border-b border-dotted border-b-main">{{ $ticket->assignee->full_name ?? 'در انتظار' }}</td>
                <td class="py-2 px-4 border-b border-dotted border-b-main">
                    {!! str_repeat('✮', number_format($ticket->satisfaction_score, 0)) !!}
                </td>
                <td class="py-2 px-4 border-b border-dotted border-b-main ltr-direction {{ $ticket->completion_date ? 'text-green-500' : 'text-gray-500' }}">
                    {{ optional($ticket->completion_date)->diffForHumans() ?? 'در صف انتظار' }}
                </td>
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
<div class="rounded-xl px-3">
    <div class="mt-4"
         x-init="$el.querySelectorAll('button, span span').forEach(button => button.classList.add('bg-main-mode', 'text-main-theme'))"
         x-effect="$el.querySelectorAll('button, span span').forEach(button => button.classList.add('bg-main-mode', 'text-main-theme'))">
        {{ $tickets->links() }}
    </div>
</div>
@include('livewire.ticket.tab-modal')


