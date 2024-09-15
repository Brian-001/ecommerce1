
<div class="flex justify-center items-center text-blue-400 gap-4">
    <div>
        <a href="{{ route('orders') }}">All Orders</a>
    </div>
    <div>
        @if (isset($store))
            <a href="{{ route('store.orders', ['storeId' => $store->id]) }}">Store Orders</a>
        @else
            <a href="#">No Store Available</a>
        @endif

    </div>
</div>
