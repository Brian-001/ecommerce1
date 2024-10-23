<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    
    public ?Store $store = null;

    public $search = '';

    public $sortCol;

    public $sortAsc = false;


    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function sortBy($column)
    {
        $this->sortCol = $column;
    }
    
    protected function applySorting($query)
    {
        //Get a value out of sortCol
        if ($this->sortCol)
        {
            $column = match($this->sortCol)
            {
                //sortable values
                'number' => 'number',
                'status' => 'status',
                'date' => 'ordered_at',
                'amount' => 'amount'
            };

            $query->orderBy($column, $this->sortAsc ? 'asc' : 'desc');
        }
        return $query;
    }
    protected function applySearch($query)
    {
        return $this->search === ''
        ? $query
        : $query
        ->where('email', 'like', '%'. $this->search .'%')
        ->orWhere('number', 'like', '%'.$this->search.'%')
        ->orWhere('status', 'like', '%'.$this->search.'%');
    }

    public function mount($storeId = null)
    {
        $this->store = $storeId ? Store::findOrFail($storeId) : null;
    }

    public function render()
    {
        
        //Initialize the query based on whether the store is set
        if($this->store)
        {
            $query = $this->store->orders();
        } else{
            $query = Order::query();
        }

        //Apply Search filter
        $query = $this->applySearch($query);

        //Apply Sort filter
        $query = $this->applySorting($query);

        //paginate the results
        $orders = $query->paginate(10);

        //Log orders to see if they are being fetched
        Log::info($orders);
        
        return view('livewire.order.index.page',[
            'orders' => $orders,
        ]);
    }
}
