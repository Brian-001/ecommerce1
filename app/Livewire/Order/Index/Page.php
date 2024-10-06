<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;
use function Livewire\store;
use Livewire\Attributes\Url;

use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use Spatie\SimpleExcel\SimpleExcelWriter;

class Page extends Component
{
    use WithPagination;

    public $orders;
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

    // #[Renderless]
    public function exportToCsv()
    {
        //Fetch all orders
        $orders->Order::all();
        
        SimpleExcelWriter::download($orders, 'orders.csv', function($excel)
        {
            //Define column headers
            $excel->addRow(['order', 'status', 'customer', 'date', 'amount']);

            //Add each order in a separate row in csv
            foreach($orders as $order)
            {
                $excel->addRow([$order->number, $order->status, $order->email, $order->ordered_at, $order->amount]);
            }
        });
        
    }

    public function updatedSearch()
    {
        // Reset pagination to the first page when search changes
        $this->resetPage();
    }

    public function refund(Order $order)
    {
        $this->authorize('update', $order);

        $order->refund();
    }

    public function archive(Order $order)
    {
        $this->authorize('update', $order);

        $order->archive();
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
