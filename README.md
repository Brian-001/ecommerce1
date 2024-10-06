# Laravel 11 and SQLite Database

## How to format date in a human readable format using Laravel?

I assume you have a `migration` called `orders` in your database and also you have a column named `ordered_at`

When creating a migration `orders` you should have the following:

```php
table->timestamp('ordered_at')->nullable();
$table->timestamps();
```
In your model you should have the following:

```php
<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['ordered_at',];

    //Added accesor for ordered_at attribute
    public function getOrderedAtAttribute($value)
    {
        return Carbon::parse($value)->format('j F, Y');
    } 
}
```
## Explanation
Laravel uses `Carbon` library to parse the `$value`(whis is the original timestamp for ordered_at).

`j` represents the month without leading zeros.

`F` represents the month in full.

`Y` represents the year in four digits.

In your blade view you can now access ordered_at

```php
{{ $order->ordered_at}}
```
The output of the above should be in the following format:
`day month, and Year` for instance: `26 August, 2024`


## Pagination and Search
When you apply search filter, the results are filtered based on the criteria you specified
`applySearch()` if the filtered results are not on the current page they won't see them even
if they exist in the next page.

If you are on the last page and the results do not fall within the limits, you will not find them.

### Solution
`Reset pagination on search` This listens for changes to the search input and reset the pagination.

This can be accomplished by adding a method that resets a page number when the search term changes.

```php
public function updatedSearch()
{
    //Resets pagination to the first page when search changes
    $this->resetPage();
}
```

## PseudoCode to implement CSV export
Step 1: Install spatie simple excel package

```php
composer require spatie/simple-excel
```
Step 2: Create livewire component (Page.php)
```php
class Page extends Component{}
```
Step 3: Define export method
```php
public funtion exportToCsv()
{
    //Fetch all existing orders in the database
    $orders = Oder::all();
}
```
Step4: Use Spatie simple excel package to create Csv

```php
SimpleExcel::download($orders, 'orders.csv', function($excel)
{
    //Define column headers if needed
    $excel->addRow(['order', 'status', 'customer', 'date', 'amount']);

    //Add each order as a row in the csv
    foreach($orders as $order)
    {
        $excel->addRow([$order->number, $order->status, $order->email, $order->ordered_at, $order->amount])
    }

});
```

Step 5: Render the view using render()
```php
public function render()
{
    return view('livewire.index')
}
```

Step 6: Update component's corresponding view

```html
<button wire:click="exportToCsv"> Export Csv </button>
```
