<?php

namespace App\Livewire\Components\Products;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PrintBarcode extends Component
{

    public function render()
    {

        $barcodes = DB::table('product_barcodes')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_barcodes.product_id')
        ->where('status', '=', 'PENDING')
        ->select('products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'product_barcodes.id as barcode_id', 'product_barcodes.barcode', 'product_barcodes.created_at')
        ->groupBy('products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'barcode_id', 'product_barcodes.barcode', 'product_barcodes.created_at')
        ->get();

        return view('livewire.components.products.print-barcode', [
            'barcodesPrint' => $barcodes
        ]);
    }
}
