<!-- Single root element -->
<div class="flex flex-col gap-8 mt-10"> 
    <!-- Search Bar -->
    <div class="relative text-sm text-gray-800 mb-4 mx-auto w-full max-w-lg"> <!-- Centered search bar -->
        <div class="absolute pl-2 left-0 top-0 bottom-0 flex items-center justify-center">
            <x-icon.magnifying-glass class="w-4 h-4 text-gray-800" />
        </div>
        {{-- .live searches as the user types and debounce determines the duration when the user stops typing and the searches --}}
        <input wire:model.live.debounce.500ms="search" type="text" placeholder="Search email or order #..." class="pl-8 p-2 border rounded-md w-1/2" />
    </div>

    <div class="flex flex-col justify-center align-center">
        <div class="relative">
            <table class="table-fixed divide-y divide-gray-300 mx-auto">
                <thead>
                    <tr>
                        <th class="p-2 text-left text-sm font-semibold text-gray-900">
                            <div wire:click="sortBy('number')">Order #</div>
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
                                <td class="whitespace-nowrap text-sm p-2">
                                    <div class="flex p-2">
                                        <span class="text-gray-800">#</span>
                                        {{$order->number}}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap text-sm p-2">
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
                                <td class="whitespace-nowrap text-sm p-2">
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
                                    {{ number_format($order->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{-- Adding a layer on top of the table for loading --}}
            <div wire:loading class="absolute inset-0 bg-white opacity-50"></div>

            {{-- Adding a spinner to our table --}}
            <div wire:loading.flex class="flex items-center justify-center absolute inset-0">
                <x-icon.spinner class="w-8 h-8 text-gray-500"/>
            </div>
        </div>
        
        <div class="mt-4 mb-8 flex items-center justify-between mx-auto w-full max-w-lg">
            <div class="mr-4">Results: {{ number_format($orders->total()) }}</div> 
            <div class="flex-1 text-center">
                {{ $orders->links('livewire.order.index.pagination') }} <!-- Custom Pagination -->
            </div>
        </div>
    </div>
</div>