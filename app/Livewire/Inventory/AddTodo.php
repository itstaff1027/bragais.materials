<?php

namespace App\Livewire\Inventory;

use Livewire\Component;

class AddTodo extends Component
{

    public $toDoProductList = [];

    public function addProduct(){
        $i = 0;
        $this->toDoProductList = array_push([$i]);
    }

    public function render()
    {
        return view('livewire.inventory.add-todo');
    }
}
