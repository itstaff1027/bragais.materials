<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class CompletePackaging extends Component
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

    private function insertCompletePackagingSale($id, $product_id, $stocks, $quantity, $status){

        $totalStocks = $this->getTotalDeduction($stocks, $quantity);

        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $id,
            'product_id' => $product_id,
            'order_number' => $this->order_number,
            'stocks' => $totalStocks,
            'quantity' => $quantity,
            'status' => $status
        ]);
    }

    private function getTotalDeduction($numberOfDeduction, $quantity){
        $computedDeduction = 0;
        $quantity == 1 ? $computedDeduction = $numberOfDeduction : $computedDeduction = $quantity * $numberOfDeduction;
        return $computedDeduction;
    }

    public function store(){

        $this->validate([
            'order_number' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        // $categoriesMapping = [
        //     'PAGEANT' => [
        //         18, // TISSUE
        //         8,  // DUST BAG
        //         [
        //             'KEVIN-V2' => [
        //                 1,  // PILLON
        //                 19, // RIBBON
        //                 [
        //                     '9-12' => 11, // Box for size 9-12
        //                     'others' => 10  // Box for other sizes
        //                 ]
        //             ],
        //             'others' => [
        //                 16, // Box
        //                 2,  // PILON
        //                 20  // RIBBON
        //             ]
        //         ]
        //     ],
        //     'HEELS' => [
        //         15, // Box
        //         3,  // PILON
        //         20, // RIBBON
        //         18, // TISSUE
        //         8   // DUST BAG
        //     ],
        //     'MANDIATOR' => [
        //         21, // Box
        //         4,  // LL PILON
        //         18, // TISSUE
        //         6   // LL DUST BAG
        //     ],
        //     'WONDIATOR' => [
        //         22, // Box
        //         4,  // LL PILON
        //         18, // TISSUE
        //         7   // LL DUST BAG
        //     ]
        // ];
    
        // $categoryMaterials = $categoriesMapping[$this->category];
    
        // foreach ($categoryMaterials as $material) {
        //     if (is_array($material)) {
        //         if (isset($material[$this->model])) {
        //             $this->insertCompletePackagingSale($material[$this->model], $quantity, $status);
        //         } else {
        //             $this->insertCompletePackagingSale($material['others'], $quantity, $status);
        //         }
        //     } else {
        //         $this->insertCompletePackagingSale($material, $quantity, $status);
        //     }
        // }
        
        // if($this->packaging_type == 'COMPLETE_PACKAGING'){
            if($this->category === "PAGEANT"){
            
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $this->product_id, -1, $this->quantity, 'OUTGOING');
    
                if($this->model == 'KEVIN-V2'){
                    // PILLON
                    $this->insertCompletePackagingSale(1, $this->product_id, -2, $this->quantity, 'OUTGOING');
                    // RIBBON
                    $this->insertCompletePackagingSale(19, $this->product_id, -1, $this->quantity, 'OUTGOING');
    
                    if($this->size >= 9 && $this->size <= 12){
                        // Box
                        $this->insertCompletePackagingSale(11, $this->product_id, -1, $this->quantity, 'OUTGOING');
                    }
                    else{
                        // Box
                        $this->insertCompletePackagingSale(10, $this->product_id, -1, $this->quantity, 'OUTGOING');
                    }
                }
                else{
                    // Box
                    $this->insertCompletePackagingSale(16, $this->product_id, -1, $this->quantity, 'OUTGOING');
                    // PILON
                    $this->insertCompletePackagingSale(2, $this->product_id, -2, $this->quantity, 'OUTGOING');
                    // RIBBON
                    $this->insertCompletePackagingSale(20, $this->product_id, -1, $this->quantity, 'OUTGOING');
                }
            }
    
            if($this->category === "HEELS"){
                // Box
                $this->insertCompletePackagingSale(15, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // PILON
                $this->insertCompletePackagingSale(3, $this->product_id, -2, $this->quantity, 'OUTGOING');
                // RIBBON
                $this->insertCompletePackagingSale(20, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $this->product_id, -1, $this->quantity, 'OUTGOING');
            }
    
            if($this->category === "MANDIATOR"){
                // Box
                $this->insertCompletePackagingSale(21, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(4, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(6, $this->product_id, -1, $this->quantity, 'OUTGOING');
            }
    
            if($this->category === "WONDIATOR"){
                // Box
                $this->insertCompletePackagingSale(22, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(4, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, $this->quantity, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(7, $this->product_id, -1, $this->quantity, 'OUTGOING');
            }
        // }

        // if($this->packaging_type == 'DUSTBAG_ONLY'){
        //     if($this->category === "MANDIATOR"){
        //         // ll DUST BAG
        //         $this->insertCompletePackagingSale(6, $this->product_id, -1, 'OUTGOING');
        //     }
        //     else if($this->category === "WONDIATOR"){
        //         // ll DUST BAG
        //         $this->insertCompletePackagingSale(7, $this->product_id, -1, 'OUTGOING');
        //     }
        //     else{
        //         // DUST BAG
        //         $this->insertCompletePackagingSale(8, $this->product_id, -1, 'OUTGOING');
        //     }
        // }

        $this->reset(['order_number']);

        return redirect('/products')->with('success', 'Successfully Addedd!');
    }

    public function render()
    {
        $products = Products::where('id', '=', $this->product_id)->first();

        $this->category = $products->category;
        $this->model = $products->model;

        return view('livewire.products.complete-packaging', [
            'product' => $products
        ]);
    }
}
