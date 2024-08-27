<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;

class Page extends Component
{
    public Store $store;
    public $orders;

    public function mount()
    {
        $this->orders = Order::all();
    }
    public function render()
    {
        // dd($this->store);
        return view('livewire.order.index.page', [
            // 'orders'=>$this->store->orders()->take(5)->get(),
        ]);
    }
}
