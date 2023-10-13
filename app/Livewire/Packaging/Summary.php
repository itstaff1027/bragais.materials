<?php

namespace App\Livewire\Packaging;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Summary extends Component
{
    public function render()
    {
        $dates = DB::table('packaging_material_logs')
            ->select(DB::raw('DATE(created_at) as date'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        $materials = DB::table('packaging_materials')->get();

        $getMaterialStocks = DB::table('packaging_material_logs')
                    ->select(DB::raw('DATE(created_at) as date'), 'packaging_material_id', DB::raw('SUM(stocks) as total_stocks'), 'status')
                    ->groupBy(DB::raw('DATE(created_at)'), 'packaging_material_id', 'status')
                    ->get();

        return view('livewire.packaging.summary', compact('dates', 'materials', 'getMaterialStocks'));

    }
}
