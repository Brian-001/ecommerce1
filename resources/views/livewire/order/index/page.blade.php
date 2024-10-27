<div>
    <div class="flex flex-col gap-8">
        <div class="grid grid-cols-2 gap-2">
            <div class="relative text-sm text-gray-800">
                <div class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500">
                    <x-icon.magnifying-glass />
                </div>
                <input id="search" name="search" wire:model.live.debounce.500ms="search" type="text" placeholder="#Search, Order, email.." class="block w-full rounded-lg border-0 py-1.5 pl-10
                text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600">
            </div>
        </div>
        <div class="relative">
            <table class="min-w-full table-fixed divide-y divide-gray-300 text-gray-800">
                <thead>
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold text-gray-900">
                            <x-orders.index.sortable column="number" :$sortCol :$sortAsc>
                                <div >Order #</div>
                            </x-orders.index.sortable>
                        </th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-900">
                            <x-orders.index.sortable column="status" :$sortCol :$sortAsc>
                               <div>Status</div>
                            </x-orders.index.sortable>
                        </th>
                        </th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-900">
                            <div>Customer</div>
                        </th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-900">
                            <x-orders.index.sortable column="date" :$sortCol :$sortAsc>
                                <div>Date</div>
                            </x-orders.index.sortable>
                        </th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-900">
                            <x-orders.index.sortable column="amount" :$sortCol :$sortAsc>
                                <div>Amount</div>
                            </x-orders.index.sortable>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white text-gray-700">
                    @foreach ($orders as $order )
                        <tr wire:key="{{$order->id}}">
                            <td class="whitespace-nowrap p3 text-sm">
                                <div class="flex gap-1">
                                    <span class="text-gray-300">#</span>
                                    {{$order->number}}
                                </div>
                            </td>
                            <td class="whitespace-nowrap p3 text-sm">
                                <div class="rounded-full py-0.5 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $order->status->color() }}-600 bg-{{ $order->status->color() }}-100">
                                    <div>{{ $order->status->label() }}</div>
                                    @if(View::exists('components.' . $order->status->icon()))
                                        <x-dynamic-component :component="$order->status->icon()" />
                                    @else
                                        <span>Icon Missing</span> <!-- Fallback content -->
                                    @endif
                                </div>                       
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full overflow-hidden">
                                        <img src="/images/avatar1.jpg" alt="">
                                    </div>
                                    <div>{{$order->email}}</div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                {{$order->ordered_at}}
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                {{number_format($order->amount, 2)}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div wire:loading class="absolute inset-0 bg-white opacity-50"></div>
            <div wire:loading.flex class="flex items-center justify-center absolute inset-0 ">
                <x-icon.spinner class="h-10 w-10"/>
            </div>
        </div>
        
        <div class="pt-4 flex justify-between items-center">
        <div class="text-gray-700 text-sm">Results: {{ number_format(($orders->total()))}}</div>
            {{ $orders->links('livewire.order.index.pagination') }}
        </div>
    </div>
</div>