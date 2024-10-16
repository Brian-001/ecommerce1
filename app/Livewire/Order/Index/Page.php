<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


class Page extends Component
{
    public ?Store $store = null;

    public function mount($storeId = null)
    {
        $this->store = $storeId ? Store::findOrFail($storeId) : null;
    }

    public function render()
    {
        $orders = $this->store ? $this->store->orders()->take(10)->get() : Order::take(10)->get();

        //Log orders to see if they are being fetched
        Log::info($orders);

        return view('livewire.order.index.page',[
            'orders' => $orders,
        ]);
    }
}
