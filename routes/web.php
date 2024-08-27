<?php

use App\Livewire\Counter;
use App\Livewire\Order\Index\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('counter', Counter::class);
Route::get('/store/{store}/orders', Page::class);
Route::get('/orders', Page::class);