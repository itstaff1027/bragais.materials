<?php

namespace App\Livewire\Packaging;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\PackagingMaterials;
use Illuminate\Support\Facades\DB;

#[Title('Add Materials Stock')]
class AddStocks extends Component
{

    public $material_id;

    public $stocks;

    public function mount($id){
        $this->material_id = $id;
    }

    public function store(){
        $this->validate([
            'stocks' => 'required|integer|min:1'
        ]);
        

        if($this->material_id == 8){
            $this->deductDustbag(23, $this->stocks);
        }
        if($this->material_id == 6){
            $this->deductDustbag(24, $this->stocks);
        }
        if($this->material_id == 7){
            $this->deductDustbag(25, $this->stocks);
        }

        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $this->material_id,
            'product_id' => 0,
            'order_number' => 0,
            'stocks' => $this->stocks,
            'status' => 'INCOMING'
        ]);


        return redirect('/packaging');
    }

    public function deductDustbag($material_id, $stocks){
        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $material_id,
            'product_id' => 0,
            'order_number' => 0,
            'stocks' => -$stocks,
            'status' => 'OUTGOING'
        ]);
    }

    public function render()
    {
        return view('livewire.packaging.add-stocks', [
            'get_material' => PackagingMaterials::where('id', '=', $this->material_id)->first()
        ]);

    }
}
