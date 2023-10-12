<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
// use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Models\PackagingMaterials;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function generatePDF()
    {

        // $today = date('Y-m-d');

        // $getTotalPilon = PackagingMaterials::where('packaging_materials.name', 'like', '%PILON%')
        // ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
        // ->leftJoin(DB::raw("(SELECT packaging_material_id, SUM(STOCKS) as released_stocks, created_at FROM packaging_material_logs WHERE status='OUTGOING' and DATE(created_at) = '{$today}' GROUP BY packaging_material_id, created_at) AS outgoing_logs"), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
        // ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'), DB::raw('MAX(outgoing_logs.created_at) as created_at'))
        // ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks')
        // ->get();


        // $getTotalRibbonToday = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        // ->whereDate('packaging_material_logs.created_at', '=', $today)
        // ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        // ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        // ->select(DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
        //     'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'packaging_material_logs.created_at')
        // ->groupBy('packaging_material_logs.created_at', 'packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->get();

        // $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        // ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        // ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        // ->select(DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
        //     'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->get();

        // $incomingRibbonStocks = DB::table('packaging_material_logs')
        // ->where('packaging_material_logs.status', '=', 'INCOMING')
        // ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        // ->select(DB::raw('SUM(packaging_material_logs.stocks) as incoming_stocks'), 'packaging_material_logs.packaging_material_id')
        // ->groupBy('packaging_material_logs.packaging_material_id')
        // ->get();
            
        // $pdf = Pdf::loadView('generate-pdf-per-day.pdf', $getTotalPilon);
        // $filename = "demo.pdf";

        // $data=[
        //     'title' => 'Generate PDF'
        // ];

        // $html = view()->make('components.PDF.generate-pdf-per-day', $data)->render();

        // $pdf= new TCPDF;

        // TCPDF::SetTitle('Hello World');
        // TCPDF::AddPage();
        // TCPDF::writeHTML($html,true,false,true,false,"");
        // TCPDF::Output(public_path($filename), "F");

        // return response()->download(public_path($filename));
        
     
        // return $pdf->download('itsolutionstuff.pdf');

        $data = [
            'title' => 'TEST'
        ];

        $pdf = Pdf::loadView('pdf.test', $data);

        return $pdf->stream();
    }
}
