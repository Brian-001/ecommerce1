
<div class="flex justify-center align-center">
    <table class=" table-fixed divide-y divide-gray-300 text-gray-800 mx-auto">
        <thead>
            <tr >
                <th class="p-2 text-left text-sm font-semibold text-gray-900">
                    <div>Order #</div>
                </th>
                <th class="p-2 text-left text-sm font-semibold text-gray-900">
                    <div>Status</div>
                </th>
                <th class="p-2 text-left text-sm font-semibold text-gray-900">
                    <div>Customer</div>
                </th>
                <th class="p-2 text-left text-sm font-semibold text-gray-900">
                    <div>Date</div>
                </th>
                <th class="p-2 text-left text-sm font-semibold text-gray-900">
                    <div>Amount</div>
                </th>
            </tr>
        </thead>
        
        <tbody class="divide-y divide-gray-200 bg-white text-gray-800">
            @if ($orders->isEmpty())
                <tr>
                    <td colspan="5" class="text-center p-2">No orders found.</td>
                </tr>
            @else
                @foreach ($orders as $order)
                    <tr wire:key="{{$order->id}}">
                        <td class="whitespace-nowrap text-sm">
                            <div class="flex p-2">
                                <span class="text-gray-800">#</span>
                                {{$order->number}}
                            </div>
                        </td>

                        <td class="whitespace-nowrap text-sm">
                            <div class="rounded-full py-0 5 pl-2 pr-1 inline-flex font-medium items-center text-green-500">
                                <div>{{$order->status}}</div>
                                <x-ei-check class="w-5 h-5"/>
                            </div>
                        </td>

                        <td class="whitespace-nowrap text-sm">
                            <div class="flex items-center p-2">
                                <div class="w-5 h-5 rounded-full overflow-hidden">
                                    <img src="/images/avatar1.jpg" alt="client_avatar">
                                </div>
                                <div>{{$order->email}}</div>
                            </div>
                        </td>

                        <td class="whitespace-nowrap text-sm p-2">
                            {{$order->ordered_at}}
                        </td>

                        <td class="w-auto whitespace-nowrap text-sm text-gray-800 font-semibold p-2">
                            {{$order->amount}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>