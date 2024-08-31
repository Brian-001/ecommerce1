@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center text-blue-400 gap-4">
    <div>
        <a href="{{ route('orders') }}">All Orders</a>
    </div>
    <div>
        {{-- <a href="{{ route('store.orders', ['store' => $store->id]) }}">Singe Order</a> --}}
    </div>
</div> 
@endsection
