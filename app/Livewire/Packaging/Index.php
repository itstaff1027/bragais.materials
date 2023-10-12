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

        $getTotalPilon = PackagingMaterials::where('packaging_materials.name', 'like', '%PILON%')
        ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
        ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as released_stocks FROM packaging_material_logs WHERE status=\'OUTGOING\' GROUP BY packaging_material_id) AS outgoing_logs'), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
        ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'))
        ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks')
        ->get();

        $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_materials.name', ['BROWN_RIBBON', 'WHITE_RIBBON'])
        ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
            'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->get();

        $incomingRibbonStocks = DB::table('packaging_material_logs')
        ->where('packaging_material_logs.status', '=', 'INCOMING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as incoming_stocks'), 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_material_logs.packaging_material_id')
        ->get();

        $outgoingRibbonStocks = DB::table('packaging_material_logs')
        ->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as outgoing_stocks'), 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_material_logs.packaging_material_id')
        ->get();

        // $getMaterialLogs = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        // ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        // ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        // ->select('packaging_material_logs.stocks', 'packaging_materials.name', 
        //     'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->groupBy('packaging_material_logs.stocks', 'packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->get();

        return view('livewire.packaging.index', [
            'packaging_materials' => PackagingMaterials::where('packaging_materials.name', 'like', '%'.$this->name_search.'%')
                ->where('packaging_materials.size', 'like', '%'.$this->size_search.'%')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs WHERE status=\'INCOMING\' GROUP BY packaging_material_id) AS beginning_stocks'), 'packaging_materials.id', '=', 'beginning_stocks.packaging_material_id')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as released_stocks FROM packaging_material_logs WHERE status=\'OUTGOING\' GROUP BY packaging_material_id) AS outgoing_logs'), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
                ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(beginning_stocks.total_stocks, 0) as beginning_total_stocks'), DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'))
                ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks', 'beginning_stocks.total_stocks')
                ->get(),
            'getTotalPilon' => $getTotalPilon,
            'getTotalRibbon' => $getTotalRibbon,
            'incomingRibbonStocks' => $incomingRibbonStocks,
            'outgoingRibbonStocks' => $outgoingRibbonStocks,
            // 'getMaterialLogs' => $getMaterialLogs
        ]);        

    }
}
