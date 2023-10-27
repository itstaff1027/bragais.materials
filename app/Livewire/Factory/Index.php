<?php

namespace App\Livewire\Factory;

use Livewire\Component;
use App\Models\Materials;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    // FILTERS - SEARCH
    public $material_sku_search = '';
    public $type_search = '';
    public $name_search = '';
    public $color_search = '';
    public $size_search = '';

    public $cart = [];

    public function addToCart($material){
        // Check if the material with the same ID already exists in the cart
        $existingItem = array_search($material['id'], array_column($this->cart, 'id'));

        if ($existingItem !== false) {
            // If the material already exists in the cart, increment the quantity by 1
            $this->cart[$existingItem]['quantity'] += 1;
        } else {
            // If the material does not exist in the cart, add it as a new item with quantity 1
            $material['quantity'] = 1;
            $this->cart[] = $material;
        }
    }

    
    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart); // Re-index the array after removal
        }
    }

    public function store(){
        dd($this->cart);
    }
    public function render()
    {
        return view('livewire.factory.index', [
            'materials' => DB::table('factory_materials')->where('factory_materials.material_sku', 'like', '%'.$this->material_sku_search.'%')
                ->where('factory_materials.type', 'like', '%'.$this->type_search.'%')
                ->where('factory_materials.name', 'like', '%'.$this->name_search.'%')
                ->where('factory_materials.color', 'like', '%'.$this->color_search.'%')
                ->where('factory_materials.size', 'like', '%'.$this->size_search.'%')
                ->leftJoin(DB::raw('(SELECT material_id, SUM(stocks) as total_stocks FROM factory_materials_stocks GROUP BY material_id) as factory_materials_stocks'), 'factory_materials.id', '=', 'factory_materials_stocks.material_id')
                ->select('factory_materials.id', 'factory_materials.material_sku', 'factory_materials.type', 'factory_materials.name', 'factory_materials.color', 'factory_materials.size', 'factory_materials.unit_per',
                        DB::raw('COALESCE(factory_materials_stocks.total_stocks, 0) as total_stocks'))
                ->groupBy('factory_materials.id', 'factory_materials.material_sku', 'factory_materials.type', 'factory_materials.name', 'factory_materials.color', 'factory_materials.size', 'factory_materials.unit_per', 'factory_materials_stocks.total_stocks')
                ->paginate(10)
        ]);
    }
}
