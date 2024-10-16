<div>
    <div class="flex flex-col-gap-8">
        <table class="min-w-full table-fixed divide-y divide-gray-300 text-gray-800">
            <thead>
                <tr>
                    <th class="p-3 text-left text-sm font-semibold text-gray-900">
                        <div>Order #</div>
                    </th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-900">
                        <div>Status</div>
                    </th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-900">
                        <div>Customer</div>
                    </th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-900">
                        <div>Date</div>
                    </th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-900">
                        <div>Amount</div>
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
    </div>
</div>