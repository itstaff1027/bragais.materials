<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{

    public $product_id;

    public $product_sku;
    public $model;
    public $color;
    public $size;
    public $heel_height;
    public $category;
    public $stocks;

    public $addStocks, $reduceStocks;
    public $addRemarks, $reduceRemarks;

    public function mount($id){
        $this->product_id = $id;
    }

    public function storeAddStocks(){

        $this->validate([
            'addStocks' => 'required|integer|min:1',
            'addRemarks' => 'required|string|max:255'
        ]);
        $user_id = Auth::id();

        DB::table('product_stocks')->insert([
            'user_id' => $user_id,
            'product_id' => $this->product_id,
            'stocks' => $this->addStocks,
            'remarks' => $this->addRemarks,
            'status' => 'INCOMING',
            'action' => 'ADD'
        ]);

        $this->reset(['addStocks', 'addRemarks']);

        return redirect('/products');
    }

    public function storeReduceStocks(){

        $this->validate([
            'reduceStocks' => 'required|integer|min:-1',
            'reduceRemarks' => 'required|string|max:255'
        ]);
        $user_id = Auth::id();

        DB::table('product_stocks')->insert([
            'user_id' => $user_id,
            'product_id' => $this->product_id,
            'stocks' => -$this->reduceStocks,
            'remarks' => $this->reduceRemarks,
            'status' => 'OUTGOING',
            'action' => 'REDUCE'
        ]);

        $this->reset(['reduceStocks', 'reduceRemarks']);

        return redirect('/products');
    }

    public function update(){
        $this->validate([
            'product_sku' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'size' => 'required|int',
            'heel_height' => 'required|int',
            'category' => 'required|string|max:255'
        ]);

        $product = Products::find($this->product_id);

        $product->product_sku = $this->product_sku;
        $product->model = $this->model;
        $product->color = $this->color;
        $product->size = $this->size;
        $product->heel_height = $this->heel_height;
        $product->category = $this->category;
        $product->save();

        $this->reset(['product_sku', 'model', 'color', 'size', 'heel_height', 'category']);

        return redirect('/products');
    }

    public function render()
    {
        $products = Products::where('products.id', '=', $this->product_id)
                    ->leftJoin(DB::raw('product_stocks'), 'product_stocks.product_id', '=', 'products.id')
                    ->select('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', DB::raw('SUM(product_stocks.stocks) as total_stocks'))
                    ->groupBy('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category')
                    ->first();


        $this->product_sku = $products->product_sku;
        $this->model = $products->model;
        $this->color = $products->color;
        $this->size = $products->size;
        $this->heel_height = $products->heel_height;
        $this->category = $products->category;
        $this->stocks = $products->total_stocks;

        return view('livewire.products.details', [
            'product' => $products
        ]);
    }
}
