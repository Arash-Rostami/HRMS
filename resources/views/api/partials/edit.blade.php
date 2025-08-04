<div class="scrollable-table" id="edit-mode" hidden>
    <table id="tableData">
        <thead>
        <tr>
            @foreach($displayableKeys as $key)
                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr id="new-record-row" class="new-record-row"></tr>
        @foreach($data as $index => $item)
            <tr id="record-{{ $item->id ?? $index }}">
                @foreach($displayableKeys as $key)
                    @php
                        $value = $item[$key] ?? null;
                        $raw = is_array($value)
                          ? implode(', ', array_map(fn($v) => is_array($v) ? implode(', ', (array)$v) : $v, $value))
                          : strip_tags($value);

                        if (in_array($key, ['primary_number','sms_number'])) {
                          $raw = preg_replace('/[^\d\+]/', '', $raw);
                        }
                    @endphp
                    <td>
                        @if($key === 'id')
                            {{ $raw }}
                        @else
                            <form>
                                @csrf
                                <input
                                    type="text"
                                    name="{{ $key }}"
                                    value="{{ htmlspecialchars($raw, ENT_QUOTES) }}"
                                    data-record-id="{{ $item['id'] ?? '' }}"
                                    data-module-name="{{ $moduleName }}"
                                    hx-patch="{{ route('crm.update', [$item['id']] ) }}"
                                    hx-trigger="change, blur"
                                    hx-vals='js:{
                                            "module":"{{ $moduleName }}",
                                            "record_id":"{{ $item['id'] ?? '' }}",
                                            "field_name":"{{ $key }}",
                                            "field_value":{{ json_encode($raw) }},
                                            "new_value": this.value
                                          }'
                                    hx-swap="none"
                                    hx-indicator="#loading"
                                    class="editable-cell-input"
                                    aria-label="Edit {{ ucfirst(str_replace('_', ' ', $key)) }}"
                                >
                            </form>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
