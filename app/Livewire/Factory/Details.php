<?php

namespace App\Livewire\Factory;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    
    public $material_id;

    public $addStocks, $reduceStocks;

    public $addRemarks = '', $reduceRemarks = '';

    public $material_sku = '';

    public $type = '';

    public $name = '';

    public $color = '';

    public $size = '';

    public $unit_per = '';

    public function mount($id){
        $this->material_id = $id;
    }

    public function storeAddStocks(){

        $this->validate([
            'addStocks' => 'required|integer|min:1',
            'addRemarks' => 'required|string|max:255'
        ]);
        $user_id = Auth::id();

        DB::table('factory_materials_stocks')->insert([
            'user_id' => $user_id,
            'material_id' => $this->material_id,
            'stocks' => $this->addStocks,
            'remarks' => $this->addRemarks,
            'status' => 'INCOMING',
            'action' => 'ADD'
        ]);

        $this->reset(['addStocks', 'addRemarks']);

        return redirect('/factory');
    }

    public function storeReduceStocks(){

        $this->validate([
            'reduceStocks' => 'required|integer|min:-1',
            'reduceRemarks' => 'required|string|max:255'
        ]);
        $user_id = Auth::id();

        DB::table('factory_materials_stocks')->insert([
            'user_id' => $user_id,
            'material_id' => $this->material_id,
            'stocks' => -$this->reduceStocks,
            'remarks' => $this->reduceRemarks,
            'status' => 'OUTGOING',
            'action' => 'REDUCE'
        ]);

        $this->reset(['reduceStocks', 'reduceRemarks']);

        return redirect('/factory');
    }

    public function update(){
        $this->validate([
            'material_sku' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'unit_per' => 'required|string|max:255'
        ]);

        $material = DB::table('factory_materials')->find($this->material_id);

        $material->material_sku = $this->material_sku;
        $material->type = $this->type;
        $material->name = $this->name;
        $material->color = $this->color;
        $material->size = $this->size;
        $material->unit_per = $this->unit_per;
        $material->save();

        $this->reset(['material_sku', 'type', 'name', 'color', 'size', 'unit_per']);

        return redirect('/factory');
    }
    
    public function render()
    {
        $materials = DB::table('factory_materials')->where('factory_materials.id', '=', $this->material_id)
        ->leftJoin(DB::raw('factory_materials_stocks'), 'factory_materials.id', '=', 'factory_materials_stocks.material_id')
        ->select('factory_materials.id', 'factory_materials.material_sku', 'factory_materials.type', 'factory_materials.name', 'factory_materials.color', 'factory_materials.size', 'factory_materials.unit_per',
                DB::raw('SUM(factory_materials_stocks.stocks) as total_stocks'))
        ->groupBy('factory_materials.id', 'factory_materials.material_sku', 'factory_materials.type', 'factory_materials.name', 'factory_materials.color', 'factory_materials.size', 'factory_materials.unit_per')
        ->first();

        $this->material_sku = $materials->material_sku;
        $this->type = $materials->type;
        $this->name = $materials->name;
        $this->color = $materials->color;
        $this->size = $materials->size;
        $this->unit_per = $materials->unit_per;

        return view('livewire.factory.details', [
            'get_material' => $materials
        ]);
    }
}
