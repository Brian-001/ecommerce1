<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Fetch all existing products
        $products = Product::all();

        //Create 10 orders associating them with existing products

        foreach ($products as $product)
        {
            Order::factory()->create([
                'product_id' => $product->id, //Associate with an existing product
                'store_id' => $product->store_id, //Associate with the store of a product
            ]);
        }
    }
}
