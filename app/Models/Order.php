<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'number', 'email', 'amount', 'status', 'ordered_at', 'product_id', 'store_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
