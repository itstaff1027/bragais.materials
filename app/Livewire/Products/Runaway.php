<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Runaway')]
class Runaway extends Component
{
    public $quantity = 0;
    public $po_number = 0;

    public function addUniqueCode(){
        for($i = 1; $i <= $this->quantity; $i++){
            $code = $this->generateUniqueCode(8);
            DB::table('runaway_unique_codes')->insert([
                'uuid' => Str::uuid()->toString(),
                'left'=> $code,
                'right' => $code,
                'customer' => 'P'.$this->po_number
            ]);
        };
    }

    public function generateUniqueCode($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        $maxIndex = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $maxIndex)];
        }
        return $code;
    }
    

    public function render()
    {
        return view('livewire.products.runaway');
    }
}
