<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Modules</title>
{{--    <style>--}}
{{--        body, html {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            height: 100%;--}}
{{--            background-color: #53636b;--}}
{{--        }--}}

{{--        .container {--}}
{{--            width: 100%;--}}
{{--            max-width: 1400px;--}}
{{--            margin: 20px auto;--}}
{{--            padding: 20px;--}}
{{--            background-color: white;--}}
{{--            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);--}}
{{--            height: calc(100vh - 40px - 40px);--}}
{{--            overflow: hidden;--}}
{{--            border-radius: 8px;--}}
{{--        }--}}

{{--        .scrollable-table {--}}
{{--            height: 100%;--}}
{{--            overflow-x: auto;--}}
{{--            white-space: nowrap;--}}
{{--        }--}}

{{--        table {--}}
{{--            min-width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--            border-radius: 8px;--}}
{{--            background-color: white;--}}
{{--            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}

{{--        th, td {--}}
{{--            text-align: left;--}}
{{--            border-bottom: 1px solid #ddd;--}}
{{--            padding: 8px 12px;--}}
{{--        }--}}

{{--        th {--}}
{{--            background-color: lightslategray;--}}
{{--            color: white;--}}
{{--            font-size: 16px;--}}
{{--            font-weight: normal;--}}
{{--        }--}}

{{--        tr:nth-child(even) {--}}
{{--            background-color: #f2f2f2;--}}
{{--        }--}}

{{--        tr:hover {--}}
{{--            background-color: #ddd;--}}
{{--        }--}}

{{--        .button-container {--}}
{{--            display: flex;--}}
{{--            justify-content: flex-end;--}}
{{--            padding: 10px 0;--}}
{{--            background-color: white;--}}
{{--            border-bottom: 1px solid #ddd;--}}
{{--        }--}}

{{--        .button {--}}
{{--            margin-left: 10px;--}}
{{--            padding: 8px 15px;--}}
{{--            background-color: lightslategray;--}}
{{--            color: white;--}}
{{--            text-align: center;--}}
{{--            border-radius: 5px;--}}
{{--            text-decoration: none;--}}
{{--            font-size: 16px;--}}
{{--            border: none;--}}
{{--            cursor: pointer;--}}
{{--            transition: background-color 0.3s ease;--}}
{{--            font-weight: normal;--}}
{{--        }--}}

{{--        .button:hover {--}}
{{--            background-color: darkslategray;--}}
{{--        }--}}

{{--        .container {--}}
{{--            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);--}}
{{--        }--}}

{{--        .back-button {--}}
{{--            width: 150px;--}}
{{--            font-weight: bold;--}}
{{--            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}

{{--        .back-button:hover {--}}
{{--            background-color: darkslategray;--}}
{{--            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);--}}
{{--        }--}}

{{--        h1.text-center {--}}
{{--            font-size: 24px;--}}
{{--            color: #2c3e50;--}}
{{--            font-weight: bold;--}}
{{--            text-align: center;--}}
{{--            padding: 10px 0;--}}
{{--            margin-bottom: 20px;--}}
{{--            /*background-color: #f8f9fa;*/--}}
{{--            border-radius: 5px;--}}
{{--            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}
{{--    </style>--}}
{{--    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>--}}
</head>
<body>
<div class="container">
    <h1 class="text-center"> API Response for {{ count($data) }} records</h1>
    <div class="button-container">
        <button onclick="history.back()" class="button">
            <span class="text-black">◀</span> Go Back
        </button>
        <button onclick="exporter.exportToExcel()" class="button">
            <span class="text-black">▼</span> Export to Excel
        </button>
        <button onclick="exporter.exportToCSV()" class="button">
            <span class="text-black">▼</span> Export to CSV
        </button>
    </div>

    @if(isset($data) && count($data) > 0)
        <div class="scrollable-table">
            <table class="table table-bordered" id="tableData">
                <thead>
                <tr>
                    @foreach(array_keys((array)$data[0]) as $key)
                        @if(!empty(array_filter(array_column($data, $key))))
                            <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $index => $item)
                    <tr>
                        @foreach($item as $key => $value)
                            @if(!empty(array_filter(array_column($data, $key))))
                                <td>
                                    @if(is_array($value))
                                        {{ implode(', ', array_map(function($v) { return is_array($v) ? implode(', ', (array)$v) : $v; }, $value)) }}
                                    @elseif(strpos($value, 'href') !== false)
                                        {!! strip_tags($value, '<a><img>') !!}
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No data available to display.</p>
    @endif
</div>
{{--<script>--}}
{{--    class TableExporter {--}}

{{--        constructor(tableId) {--}}
{{--            this.table = document.getElementById(tableId);--}}
{{--        }--}}

{{--        exportToExcel(filename = 'data-export.xlsx') {--}}
{{--            let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"});--}}
{{--            XLSX.writeFile(workbook, filename);--}}
{{--        }--}}

{{--        exportToCSV(filename = 'data-export.csv') {--}}
{{--            let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"});--}}
{{--            let csv = XLSX.utils.sheet_to_csv(workbook.Sheets[workbook.SheetNames[0]]);--}}
{{--            this.downloadCSV(csv, filename);--}}
{{--        }--}}

{{--        downloadCSV(csv, filename) {--}}
{{--            let csvFile = new Blob([csv], {type: "text/csv"});--}}
{{--            let downloadLink = document.createElement("a");--}}
{{--            downloadLink.download = filename;--}}
{{--            downloadLink.href = window.URL.createObjectURL(csvFile);--}}
{{--            downloadLink.style.display = "none";--}}
{{--            document.body.appendChild(downloadLink);--}}
{{--            downloadLink.click();--}}
{{--        }--}}
{{--    }--}}

{{--    let exporter = new TableExporter('tableData');--}}
{{--</script>--}}
</body>
</html>
