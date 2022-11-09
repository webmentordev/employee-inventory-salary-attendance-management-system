@section('title', 'Stock History | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Stock History</span></h1>
    <div class="bg-white p-3 rounded-lg">
        @if ($stockHistory != null)
            @if ($stockHistory->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">SockSize</th>
                    <th class="px-2 py-4">MainUnit</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                </tr>
        
                @foreach ($stockHistory as $key => $stock)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $stock->stock_size }}</td>
                        <td class="py-3">{{ $stock->main_unit->name }}</td>
                        <td class="py-3">{{ $stock->created_at->format('D, d, M Y H:i A') }}</td>
                        <td class="py-3">{{ $stock->updated_at->format('D, d, M Y H:i A') }}</td>
                    </tr>
                @endforeach
            </table>
            @else
                <p class="text-2xl">No Data available about Stock!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Stock!</p>
        @endif
    </div>
</div>
