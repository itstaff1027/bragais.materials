<?php

namespace App\Livewire\Products;

use Error;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class NewModel extends Component
{

    public $product_sku;
    public $product_category;
    public $product_model;
    public $product_color;
    public $product_size;
    public $product_heel_height;
    public $product_price;
    public $size_type;

    public function store(){

        $this->validate([
            'product_sku' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_model' => 'required|string|max:255',
            'product_color' => 'required|string|max:255',
            'product_heel_height' => 'required',
            'product_price' => 'required',
            'size_type' => 'required'
        ]);

        if($this->size_type == 'US'){
            $sizes = ['5', '6', '7', '8', '9', '10', '11', '12'];
        }

        if($this->size_type == 'EURO'){
            $sizes = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
        }

        if(!$this->size_type){
            throw new Error('Unkown data!');
        }

        foreach($sizes as $size){
            DB::table('products')->insert([
                'product_sku' => "{$this->product_sku}{$size}N{$this->product_heel_height}",
                'model' => $this->product_model,
                'color' => $this->product_color,
                'size' => $size,
                'heel_height' => $this->product_heel_height,
                'category' => $this->product_category,
                'price' => $this->product_price,
                'stocks' => 0,
                'BatchNo' => 0
            ]);
        }

        $this->reset(['product_sku', 'product_category', 'product_model', 'product_color', 'product_size', 'product_heel_height']);

        return redirect('/products');
    }

    public function render()
    {
        return view('livewire.products.new-model');
    }
}
