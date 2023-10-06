<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Materials;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    
    public $material_id;

    public $stocks;

    public $remarks = '';

    public $material_sku = '';

    public $type = '';

    public $name = '';

    public $color = '';

    public $size = '';

    public $unit_per = '';

    public function mount($id){
        $this->material_id = $id;
    }

    public function store(){

        $this->validate([
            'stocks' => 'required|integer|min:1',
            'remarks' => 'required|string|max:255'
        ]);
        $user_id = Auth::id();

        DB::table('materials_stocks')->insert([
            'user_id' => $user_id,
            'material_id' => $this->material_id,
            'stocks' => $this->stocks,
            'remarks' => $this->remarks,
            'status' => 'INCOMING',
            'action' => 'ADD'
        ]);

        $this->reset(['stocks', 'remarks']);

        return redirect('/inventory');
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

        $material = Materials::find($this->material_id);

        $material->material_sku = $this->material_sku;
        $material->type = $this->type;
        $material->name = $this->name;
        $material->color = $this->color;
        $material->size = $this->size;
        $material->unit_per = $this->unit_per;
        $material->save();

        $this->reset(['material_sku', 'type', 'name', 'color', 'size', 'unit_per']);

        return redirect('/inventory');
    }

    public function render()
    {
        // return view('livewire.inventory.details', [
        //     'get_stock' => Materials::where('id', '=', $this->product_id)
        //     ->leftJoin(DB::raw('stock_logs'), 'id', '=', 'stock_logs.product_id') 
        //     ->select('id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'products.price', 'products.order_from',
        //                   DB::raw('SUM(stock_logs.stocks) as total_stocks'))
        //     ->groupBy('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'products.price', 'products.order_from')          
        //     ->first()
        // ]);

        $materials = Materials::where('materials.id', '=', $this->material_id)
                                ->leftJoin(DB::raw('materials_stocks'), 'materials.id', '=', 'materials_stocks.material_id')
                                ->select('materials.id', 'materials.material_sku', 'materials.type', 'materials.name', 'materials.color', 'materials.size', 'materials.unit_per',
                                        DB::raw('SUM(materials_stocks.stocks) as total_stocks'))
                                ->groupBy('materials.id', 'materials.material_sku', 'materials.type', 'materials.name', 'materials.color', 'materials.size', 'materials.unit_per')
                                ->first();

        $this->material_sku = $materials->material_sku;
        $this->type = $materials->type;
        $this->name = $materials->name;
        $this->color = $materials->color;
        $this->size = $materials->size;
        $this->unit_per = $materials->unit_per;
        
        return view('livewire.inventory.details', [
            'get_material' => $materials
        ]);
    }
}
