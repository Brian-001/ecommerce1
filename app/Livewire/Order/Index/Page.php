<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;

use function Livewire\store;

class Page extends Component
{
    use WithPagination;

    public $storeId;
    public $search = ''; 
    
    public function mount($storeId = null) //Accept store as a parameter
    {
        $this->storeId = $storeId;
    }

    public function render()
    {
        if ($this->storeId) {
            $store = Store::find($this->storeId);
            if ($store) {
                $orders = $store->orders()->paginate(10); // Paginate orders for the store
            } else {
                $orders = collect(); // Initialize to an empty collection if store not found
            }
        } else {
            $orders = Order::paginate(10); // Paginate all orders
        }
        
        return view('livewire.order.index.page', [
            'orders' => $orders, // Pass the orders to the view
        ]);
    }
    
}
