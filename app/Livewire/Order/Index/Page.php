<?php

namespace App\Livewire\Order\Index;

use App\Models\Order;
use App\Models\Store;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class Page extends Component
{
    use WithPagination;
    
    public ?Store $store = null;

    public $search = '';

    #[Url] 
    public $sortCol;

    #[Url] 
    public $sortAsc = false;


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function export()
    {
        $orders = $this->store ? $this->store->orders()->get() : Order::all();
        $csv = $this->convertToCsv($orders);
        
        return Response::streamDownload(function () use ($csv) {
            echo $csv;
        }, 'orders.csv');
    }

    private function convertToCsv($orders)
    {
        //Initializes an empty string to csvData
        $csvData = '';
        //Create an array header containing column names for csv data
        $headers = ['Number', 'Email', 'Amount', 'Status', 'Ordered At'];

        //Concatenates header into a single seperated string
        //implode(',', $headers) converts the array to csv header row and results is appended to csvData
        $csvData .= implode(',', $headers) . "\n";
        
        //Iterates $order in  $orders collection
        foreach ($orders as $order) {
            $csvData .= implode(',', [
                $order->number,
                $order->email,
                number_format($order->amount, 2),
                $order->status->label(),
                $order->ordered_at,
            ]) . "\n";
        }
        //csvData string is returned from the function
        return $csvData;
    }

    public function refund(Order $order)
    {
        // $this->authorize('update', $order);
        $order->refund();
    }

    public function archive(Order $order)
    {
        // $this->authorize('update', $order);
        $order->archive();
    }

    public function sortBy($column)
    {
        if ($this->sortCol === $column)
        {
            $this->sortAsc = ! $this->sortAsc;
        } else{
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
        
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
        // if($this->store)
        // {
        //     $query = $this->store->orders();
        // } else{
        //     $query = Order::query();
        // }
        $query = $this->store ? $this->store->orders() : Order::query();

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
