<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use function Livewire\store;

class Page extends Component
{
    use WithPagination;

    public $storeId;
    public $search = ''; 

    #[Url]
    public $sortCol;
    #[Url]
    public $sortAsc = false;
    
    public function mount($storeId = null) //Accept store as a parameter
    {
        $this->storeId = $storeId;
    }
    public function updatedSearch()
    {
        // Reset pagination to the first page when search changes
        $this->resetPage();
    }

    public function sortBy($column)
    {
        //Checks if sorted column is the same as the clicked column
        if ($this->sortCol === $column)
        {
            //Toggle sorting direction to (ascending/descending)
            $this->sortAsc = ! $this->sortAsc;
        }else{
            //Set the new column to sortby and reset sorting direction to descending
            $this->sortCol = $column; //Update the sort column
            $this->sortAsc = false; //Default to descending order
        }
        
    }

    protected function applySorting($query)
    {
        //Check if sort column is set
        if($this->sortCol)
        {
            //Determine the actual column to sort by using match expression
            $column = match($this->sortCol)
            {
                'number' => 'number',
                'status' => 'status',
                'date' => 'ordered_at',
                'amount' => 'amount',
            };
            //Apply sorting to the query based on the column and direction
            $query->orderBy($column, $this->sortAsc ? 'asc' : 'desc');
        }
        return $query;// Return the modified query
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

        //Apply sort filters if any
        $this->applySorting($query);

        //Paginate the results
        $orders = $query->paginate(10);
        
        return view('livewire.order.index.page', [
            // Pass the orders to the view
            'orders' => $orders, 
        ]);
    }
    
}
