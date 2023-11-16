<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GenerateBarcode extends Component
{

    public $product_id;

    public $product_sku;
    public $model;
    public $color;
    public $size;
    public $heel_height;
    public $category;
    public $stocks;

    public $addBarcode;

    public $quantity;

    public function mount($id){
        $this->product_id = $id;
    }

    public function generateBarcode(){

        $this->validate([
            "quantity" => "required|integer|min:1"
        ]);

        $user_id = Auth::user()->id;

        $today = date('Ymd'); // Get current date in YYYYMMDD format

        $barcode = "{$today}-{$this->product_id}";

        for($i=0; $i < $this->quantity; $i++){
            
            DB::table('product_barcodes')->insert([
                'user_id' => $user_id,
                'product_id' => $this->product_id,
                'barcode' => $barcode
            ]);
        }

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

        $today = date('Ymd'); // Get current date in YYYYMMDD format

        $barcode = $today . '-' . $products->product_id . '-1';

        return view('livewire.products.generate-barcode', [
            'product' => $products,
            'barcode' => $barcode
        ]);
    }
}
