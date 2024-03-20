<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\PulloutExport;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

#[Title('Pullouts')]
class Pullouts extends Component
{
    use WithPagination;


    public $product_id;
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';
    public $order_from;

    public function getDate(){
        $today = date('m');
        return $today;
    }

    public function __construct(){
        $this->filter_date = $this->getDate();
    }

    public function export()
    {
        return Excel::download(new PulloutExport($this->filter_date), "OUTGOING_PULLOUT_{$this->getDate()}.xlsx");
    }

    public function filterBySoldFrom($value){
        $this->order_from = $value;
    }

    public function render(){
        $today = $this->filter_date;

        $query = DB::table('pullouts')
            ->whereMonth(DB::raw('DATE(created_at)'), '=', $this->filter_date)
            ->select(
                'agent_number',  
                'order_number',
                'customer_details',
                'order_lists',
                'packaging_type',
                'sold_date',
                'remarks',
                'notes',
                'is_replacement'
            )
            ->groupBy(
                'agent_number',
                'order_number',
                'customer_details',
                'order_lists',
                'packaging_type',
                'sold_date',
                'remarks',
                'notes',
                'is_replacement'
            );

        $pullouts = $query->get();

        return view('livewire.products.pullouts', [
            'pullouts' => $pullouts
        ]);
    }
}
