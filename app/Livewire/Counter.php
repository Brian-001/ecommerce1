<?php

namespace App\Livewire;

use Livewire\Component;
use PHPUnit\Framework\Constraint\Count;

class Counter extends Component
{
    public $count;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
    
    public function render()
    {
        return view('livewire.counter');
    }
}
