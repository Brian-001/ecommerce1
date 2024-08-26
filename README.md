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
