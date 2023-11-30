<?php

namespace App\Livewire\Products;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Title('Barcodes')]
class Barcode extends Component
{
    public function render()
    {

        $barcodes = DB::table('product_barcodes')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_barcodes.product_id')
        ->where('status', '=', 'PENDING')
        ->select('products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'product_barcodes.id as barcode_id', 'product_barcodes.barcode', 'product_barcodes.created_at')
        ->groupBy('products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'barcode_id', 'product_barcodes.barcode', 'product_barcodes.created_at')
        ->paginate(10);

        return view('livewire.products.barcode', [
            'barcodes' => $barcodes
        ]);
    }
}
