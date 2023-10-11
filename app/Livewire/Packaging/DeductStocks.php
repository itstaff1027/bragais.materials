<?php

namespace App\Livewire\Packaging;

use Livewire\Component;
use App\Models\PackagingMaterials;
use Illuminate\Support\Facades\DB;

class DeductStocks extends Component
{
    public $material_id;

    public $stocks;

    public function mount($id){
        $this->material_id = $id;
    }

    public function store(){
        $this->validate([
            'stocks' => 'required|integer|max:-1'
        ]);

        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $this->material_id,
            'product_id' => 0,
            'order_number' => 0,
            'stocks' => $this->stocks,
            'status' => 'OUTGOING'
        ]);

        return redirect('/packaging');
    }
    
    public function render()
    {
        return view('livewire.packaging.deduct-stocks', [
            'get_material' => PackagingMaterials::where('id', '=', $this->material_id)->first()
        ]);
    }
}
