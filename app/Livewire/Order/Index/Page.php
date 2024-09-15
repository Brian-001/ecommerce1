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
    public function updatedSearch()
    {
        // Reset pagination to the first page when search changes
        $this->resetPage();
    }
    protected function applySearch($query)
    {
        if($this->search)
        {
            $query->where(function($q){
                $q->where('number', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' .$this->search . '%');
            });
        }
    }
    public function render()
    {
        //Start with orders query
        $query = $this->storeId ? Store::find($this->storeId)->orders() : Order::query();

        //Apply search filters if any
        $this->applySearch($query);

        //Paginate the results
        $orders = $query->paginate(10);
        
        return view('livewire.order.index.page', [
            // Pass the orders to the view
            'orders' => $orders, 
        ]);
    }
    
}
