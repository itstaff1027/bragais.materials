<?php

namespace App\Livewire\Packaging;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class MaterialLogs extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.packaging.material-logs', [
            'getMaterialLogs' => DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
            ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
            ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
            ->select('packaging_material_logs.stocks', 'packaging_materials.name', 'packaging_material_logs.id as material_logs_id',
                'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
            ->groupBy('packaging_material_logs.stocks', 'packaging_materials.name', 'material_logs_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
            ->orderBy('material_logs_id', 'desc')
            ->paginate(25)
        ]);
    }
}
