<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Log::info('ProductsTableSeeder is running');

        //Fetch all stores
        $stores = Store::all();

        if($stores->isEmpty())
        {
            Log::warning('No stores found, cannot create products');
            return;
        }
        foreach($stores as $store)
        {
            Product::factory()->create(['store_id' => $store->id]);
        }
    }
}
