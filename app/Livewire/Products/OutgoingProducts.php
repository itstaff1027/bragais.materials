<?php

namespace App\Livewire\Products;

use App\Exports\OutGoingProductsExport;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

#[Title('Outgoing Products')]
class OutgoingProducts extends Component
{
    public $product_id;

    public $order_number;

    public $category;
    public $model;
    public $size;
    public $quantity;


    public $packaging_material_id;
    // public $packaging_tpye = '';

    public function mount($id){
        $this->product_id = $id;
    }

    public function putOutgoingProduct(){

        $this->validate([
            'order_number' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::table('outgoing_product_logs')->insert([
            'product_id' => $this->product_id,
            'order_number' => $this->order_number,
            'quantity' => $this->quantity,
            'status' => 'OUTGOING'
        ]);

        return redirect('/products');
        
    }

    public function render()
    {
        $products = Products::where('id', '=', $this->product_id)->first();

        $this->category = $products->category;
        $this->model = $products->model;

        return view('livewire.products.outgoing-products', [
            'product' => $products
        ]);
    }
}
