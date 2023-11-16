<?php

namespace App\Livewire\Components\Products;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\ProductBarcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddStockBarcode extends Component
{

    public $scannedBarcode;
    public $text;
    protected $listeners = ['handleBarcode', 'clearMessage'];
    public $errorMessage = false, $successMessage = false;
    public $barcodeValidationResult;

    public $arr = [];

    public function handleBarcode($scannedBarcode)
    {
       // Split the barcode into an array using the '-' delimiter
        $barcodeArray = explode('-', $scannedBarcode);
        

        foreach ($barcodeArray as $value) {
            if (!is_numeric($value)) {
                $this->errorMessage = "Unknown Barcode, Please try again!";
                // or any other logic you want to perform when a non-numeric value is found
                break; // exit the loop if a non-numeric value is found
            }
        }
        
        // If the loop completes without encountering a non-numeric value, you can proceed with further checks or processing.
        if (!$this->errorMessage) {
            if (count($barcodeArray) !== 3) {
                $this->errorMessage = "Unknown Barcode, Please try again!";
                // or any other logic you want to perform when the array doesn't have exactly 3 elements
            }
        }


        // You can access the individual parts of the barcode using array indexing
        $barcode_id = $barcodeArray[0]; // '1'
        $date_created = $barcodeArray[1]; // '20231108'
        $product_id = $barcodeArray[2]; // '25'

        $status = DB::table('product_barcodes')->select('status')->where('id', '=', $barcode_id)->first();

        if(!$status){
            $this->errorMessage = 'No barcode found, Please try again!';
        }

        $user_id = Auth::user()->id;

        if($status == 'ADDED'){
            $this->successMessage = 'Already Added, cannot be added again!' . $status->status;
        }

        // UPDATE BARCODE FROM THE LIST TO ADDED
        $barcode = ProductBarcode::find($barcode_id);
        $barcode->user_id =$user_id;
        $barcode->status = 'ADDED';
        $barcode->save();

        if($status->status == 'PENDING'){
            DB::table('product_stocks')->insert([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'order_number' => 0,
                'stocks' => 1,
                'remarks' => "Added Stocks From scan barcode {$date_created}"
            ]);

            $this->successMessage = 'Barcode processed Successfully' . $status->status;
            // return response()->json(['message' => "Barcode processed successfully {$this->scannedBarcode}{$this->errorMessage}"]);
        }

        // $this->errorMessage = '';
        // $this->successMessage = '';
        
    }

    public function render()
    {

        $today = date('Ymd');

        return view('livewire.components.products.add-stock-barcode',[
            'barcodeLists' => ProductBarcode::where('status', '=', 'ADDED')->where(DB::raw('DATE(updated_at)'), '=', $today)->paginate(10)
        ]);
    }
}
