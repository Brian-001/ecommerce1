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

## Working with dynamic class names in blade templates using Tailwindcss
To work with dynamic classes or coditional classes that might not be detectable during tailwindcss purge process you use `safelist`.

`Safelist` in `tailwind.config.js` is where you can specify class names to be included in your final build even if they are not found in template files.

For instance we have a `Status.php` enum.

```php
<?php

namespace App\Enums;


enum Status: string
{
    //
    case ARCHIVED = 'archived';
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';

    public function label() : string
    {
        return match ($this)
        {
            static::ARCHIVED => 'Archived',
            static::PAID => 'Paid',
            static::UNPAID => 'Unpaid',
            static::REFUNDED => 'Refunded',
            static::FAILED => 'Failed',
        };
    }


    public function icon() : string
    {
        return match ($this)
        {
            static::ARCHIVED => 'icon.archive-box',
            static::PAID => 'icon.check-circle',
            static::UNPAID => 'icon.clock',
            static::REFUNDED => 'icon.arrow-uturn-left',
            static::FAILED => 'icon.x-circle'
        };

    }

    public function color()
    {
        return match ($this)
        {
            static::ARCHIVED => 'gray',
            static::PAID => 'green',
            static::UNPAID => 'yellow',
            static::REFUNDED => 'blue',
            static::FAILED => 'red',
        };
    }

    
}

```
In here, we have an enum defining various statuses, each with specific methods.

>`label()` returns a human-readable label for each status.

>`icon()` returns a corresponding icon component for each status.

>`color()` returns corresponding color used in tailwind classes for each status. 

```php
<div class="rounded-full py-0.5 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $order->status->color() }}-600 bg-{{ $order->status->color() }}-100">
    <div>{{ $order->status->label() }}</div>
    @if(View::exists('components.' . $order->status->icon()))
        <x-dynamic-component :component="$order->status->icon()" />
    @else
        <span>Icon Missing</span> <!-- Fallback content -->
    @endif
</div>
```
So, in the above blade file instead of having multiple `@if` statements the above refactored code uses `color()` from `Status.php` enum to construct class names dynamically. This makes code much more cleaner and more maintainable.

`icon()` is used to determine icon component.

`View::exists` function ensures icon component exists before rendering it. It als provides a fallback statement.