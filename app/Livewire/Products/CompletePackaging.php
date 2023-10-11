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


    public $packaging_material_id;
    // public $packaging_tpye = '';

    public function mount($id){
        $this->product_id = $id;
    }

    private function insertCompletePackagingSale($id, $product_id, $stocks, $status){
        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $id,
            'product_id' => $product_id,
            'order_number' => $this->order_number,
            'stocks' => $stocks,
            'status' => $status
        ]);
    }

    public function store(){

        $array_list = [
            0 => ['id' => '1', 'name' => 'PILON', 'size' => 'LARGE'],
            1 =>['id' => '2', 'name' => 'PILON', 'size' => 'MEDIUM'],
            2 =>['id' => '3', 'name' => 'PILON', 'size' => 'SMALL'],
            3 =>['id' => '4', 'name' => 'LL_PILON_MANDIATOR', 'size' => 'ONE_SIZE'],
            4 =>['id' => '5', 'name' => 'LL_PILON_WONDIATOR', 'size' => 'ONE_SIZE'],
            5 =>['id' => '6', 'name' => 'LL_DUSTBAG_MANDIATOR', 'size' => 'ONE_SIZE'],
            6 =>['id' => '7', 'name' => 'LL_DUSTBAG_WONDIATOR', 'size' => 'ONE_SIZE'],
            7 =>['id' => '8', 'name' => 'DUSTBAG', 'size' => 'ONE_SIZE'],
            8 =>['id' => '9', 'name' => 'LGBT_BOX', 'size' => 'SMALL'],
            9 =>['id' => '10', 'name' => 'LGBT_BOX', 'size' => 'MEDIUM'],
            10 =>['id' => '11', 'name' => 'LGBT_BOX', 'size' => 'LARGE'],
            11 =>['id' => '12', 'name' => 'WHITE_BOX', 'size' => 'SMALL'],
            12 =>['id' => '13', 'name' => 'WHITE_BOX', 'size' => 'MEDIUM'],
            13 =>['id' => '14', 'name' => 'WHITE_BOX', 'size' => 'LARGE'],
            14 =>['id' => '15', 'name' => 'BROWN_BOX', 'size' => 'SMALL'],
            15 =>['id' => '16', 'name' => 'BROWN_BOX', 'size' => 'MEDIUM'],
            16 =>['id' => '17', 'name' => 'BROWN_BOX', 'size' => 'LARGE'],
            17 =>['id' => '18', 'name' => 'TISSUE_PAPER', 'size' => 'ONE_SIZE'],
            18 =>['id' => '19', 'name' => 'WHITE_RIBBON', 'size' => 'ONE_ROLL'],
            19 =>['id' => '20', 'name' => 'BROWN_RIBBON', 'size' => 'ONE_ROLL'],
            20 =>['id' => '21', 'name' => 'MANDIATOR_BOX', 'size' => 'ONE_SIZE'],
            21 =>['id' => '22', 'name' => 'WONDIATOR_BOX', 'size' => 'ONE_SIZE']
        ];
        
        // if($this->packaging_type == 'COMPLETE_PACKAGING'){
            if($this->category === "PAGEANT"){
            
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $this->product_id, -1, 'OUTGOING');
    
                if($this->model == 'KEVIN-V2'){
                    // PILLON
                    $this->insertCompletePackagingSale(1, $this->product_id, -2, 'OUTGOING');
                    // RIBBON
                    $this->insertCompletePackagingSale(19, $this->product_id, -1, 'OUTGOING');
    
                    if($this->size >= 9 && $this->size <= 12){
                        // Box
                        $this->insertCompletePackagingSale(14, $this->product_id, -1, 'OUTGOING');
                    }
                    else{
                        // Box
                        $this->insertCompletePackagingSale(13, $this->product_id, -1, 'OUTGOING');
                    }
                }
                else{
                    // Box
                    $this->insertCompletePackagingSale(16, $this->product_id, -1, 'OUTGOING');
                    // PILON
                    $this->insertCompletePackagingSale(2, $this->product_id, -2, 'OUTGOING');
                    // RIBBON
                    $this->insertCompletePackagingSale(20, $this->product_id, -1, 'OUTGOING');
                }
            }
    
            if($this->category === "HEELS"){
                // Box
                $this->insertCompletePackagingSale(15, $this->product_id, -1, 'OUTGOING');
                // PILON
                $this->insertCompletePackagingSale(3, $this->product_id, -2, 'OUTGOING');
                // RIBBON
                $this->insertCompletePackagingSale(20, $this->product_id, -1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $this->product_id, -1, 'OUTGOING');
            }
    
            if($this->category === "MANDIATOR"){
                // Box
                $this->insertCompletePackagingSale(21, $this->product_id, -1, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(4, $this->product_id, -1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(6, $this->product_id, -1, 'OUTGOING');
            }
    
            if($this->category === "WONDIATOR"){
                // Box
                $this->insertCompletePackagingSale(22, $this->product_id, -1, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(5, $this->product_id, -1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $this->product_id, -1, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(7, $this->product_id, -1, 'OUTGOING');
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
