
<div class="flex flex-col justify-center align-center">
    <table class=" table-fixed divide-y divide-gray-300 mx-auto">
        <thead>
            <tr>
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
                            <div class="rounded-full py-0 px-2 inline-flex font-medium items-center 
                                @if ($order->status->label() === 'Paid') bg-green-500 text-white 
                                @elseif ($order->status->label() === 'Unpaid') bg-yellow-500 text-white 
                                @elseif ($order->status->label() === 'Refunded') bg-blue-500 text-white 
                                @elseif ($order->status->label() === 'Failed') bg-red-500 text-white 
                                @elseif ($order->status->label() === 'Archived') bg-gray-500 text-white 
                                @endif">
                                
                                <div>{{ $order->status->label() }}</div>
                                
                                @if ($order->status->label() === 'Paid')
                                    <x-icon.check-circle class="h-5 w-5 text-white" />
                                @elseif ($order->status->label() === 'Unpaid')
                                    <x-icon.clock class="h-5 w-5 text-white" />
                                @elseif ($order->status->label() === 'Refunded')
                                    <x-icon.arrow-uturn-left class="h-5 w-5 text-white" />
                                @elseif ($order->status->label() === 'Failed')
                                    <x-icon.x-circle class="h-5 w-5 text-white" />
                                @elseif ($order->status->label() === 'Archived')
                                    <x-icon.archive-box class="h-5 w-5 text-white" />
                                @endif
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

                        <td class="whitespace-nowrap text-sm p-2 ">
                            {{$order->ordered_at}}
                        </td>

                        <td class="w-auto whitespace-nowrap text-sm p-2">
                            {{$order->amount}}
                            {{-- Number::currency() --}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        <div> Results: 50</div> 
        <div>{{ $orders->links() }}</div>
        
        {{-- <div>{{ $orders->links('livewire.order.index.pagination') }}</div> --}}
        {{-- <div>{{$orders->total()}}</div> --}}
    </div>
</div>