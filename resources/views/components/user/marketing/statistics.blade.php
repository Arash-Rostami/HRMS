<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARV CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-700">
<div class="container mx-auto p-4">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" style="direction: rtl">
        <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center mx-auto">Account List</h2>
                @if($paginator->isEmpty())
                    <p>No accounts found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                            <tr class="mx-auto text-center">
                                <th class="px-6 py-3 bg-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider mx-auto text-center">
                                    Name
                                </th>
                                <th class="px-6 py-3 bg-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider mx-auto text-center">
                                    Type
                                </th>
                                <th class="px-6 py-3 bg-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider mx-auto text-center">
                                    Assigned User
                                </th>
                                <th class="px-6 py-3 bg-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider mx-auto text-center">
                                    Primary Number
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($paginator as $account)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 bg-gray-400">{{ $account['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 bg-gray-400">{{ $account['type'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 bg-gray-400">{{ $account['assigned_user_name'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 bg-gray-400">{{ $account['primary_number_raw'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $paginator->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <a href="{{ route('apiTest', ['page' => $paginator->currentPage() + 1]) }}"
       class="bg-gray-400 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Load Next 100 Records
    </a>
</div>
</body>
</html>
