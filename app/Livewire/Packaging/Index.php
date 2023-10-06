<?php

namespace App\Livewire\Packaging;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\PackagingMaterials;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    // FILTERS - SEARCH
    public $name_search = '';

    public $size_search = '';

    public function render()
    {
        return view('livewire.packaging.index', [
            'packaging_materials' => PackagingMaterials::where('packaging_materials.name', 'like', '%'.$this->name_search.'%')
                ->where('packaging_materials.size', 'like', '%'.$this->size_search.'%')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as released_stocks FROM packaging_material_logs WHERE status=\'OUTGOING\' GROUP BY packaging_material_id) AS outgoing_logs'), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
                ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'))
                ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks')
                ->paginate(25)
        ]);        

    }
}
