<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'number', 'email', 'amount', 'status', 'ordered_at', 'product_id', 'store_id'];

    //Added an accessor for ordered_at attribute
    public function getOrderedAtAttribute($value)
    {
        return Carbon::parse($value)->format('j F, Y');
    }

    //Added an accessor for status attribute
    public function getStatusAttribute($value)
    {
        return Status::from($value);
    }
    public function amountForHumans()
    {
        return Number::currency($this->amount);
    }
    //Eloquent Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
