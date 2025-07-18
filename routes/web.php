<?php

use App\Livewire\Counter;
use App\Livewire\Order\Index\Page;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('counter', Counter::class);

Route::get('/store/{storeId}/orders', Page::class)->name('store.orders');
Route::get('/orders', Page::class)->name('orders');
