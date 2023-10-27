<?php

namespace App\Livewire\Factory;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NewModel extends Component
{

    public $material_sku;
    public $material_type;
    public $material_name;
    public $material_color;
    public $material_size;
    public $material_unit;

    public function store(){

        $this->validate([
            'material_sku' => 'required|string|max:255',
            'material_type' => 'required|string|max:255',
            'material_name' => 'required|string|max:255',
            'material_color' => 'required|string|max:255',
            'material_size' => 'required|string|max:255',
            'material_unit' => 'required|string|max:255',
        ]);

        DB::table('factory_materials')->insert([
            'user_id' => Auth::user()->id,
            'material_sku' => $this->material_sku,
            'type' => $this->material_type,
            'name' => $this->material_name,
            'color' => $this->material_color,
            'size' => $this->material_size,
            'unit_per' => $this->material_unit,
        ]);

        $this->reset(['material_sku', 'material_type', 'material_name', 'material_color', 'material_size', 'material_unit']);

        return redirect('/factory');
    }

    public function render()
    {
        return view('livewire.factory.new-model');
    }
}
