<div class="scrollable-table" id="view-mode">
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
                        {{ $raw }}
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
