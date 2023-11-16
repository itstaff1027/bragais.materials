<?php

namespace App\Livewire\Components\Products;

use Error;
use Exception;
use Throwable;
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
    public $errorMessage = '', $successMessage = '';
    public $is_error = false;
    public $is_success = false;
    public $barcodeValidationResult;

    public $arr = [];

    public function handleBarcode($scannedBarcode)
    {
       // Split the barcode into an array using the '-' delimiter
       try{
            $barcodeArray = explode('-', $scannedBarcode);

            foreach ($barcodeArray as $value) {
                if (!is_numeric($value)) {
                    $this->is_error = true;
                    $this->errorMessage = "Unknown Barcode, Please try again!";
                    return $this->errorMessasge;
                    // throw new Error("Unknown Barcode, Please try again!");
                }
            }
            
            // If the loop completes without encountering a non-numeric value, you can proceed with further checks or processing.
            if (!$this->errorMessage) {
                if (count($barcodeArray) !== 3) {
                    $this->is_error = true;
                    $this->errorMessage = "Unknown Barcode, Please try again!";
                    return $this->errorMessasge;
                    // throw new Error("Unknown Barcode, Please try again!");
                }
            }
    
    
            // You can access the individual parts of the barcode using array indexing
            $barcode_id = $barcodeArray[0]; // '1'
            $date_created = $barcodeArray[1]; // '20231108'
            $product_id = $barcodeArray[2]; // '25'

       } catch (Throwable $e){
            $this->is_error = true;
            if ($e instanceof Exception) {
                // Handle Exception objects
                $this->errorMessage = $e->getMessage();
            } elseif ($e instanceof Error) {
                // Handle Error objects
                // Replace this with your own error handling logic
                $this->errorMessage = 'An error occurred';
            }
            // Re-throw the error to stop function execution
            throw $e;
       } 

       try{
            $status = DB::table('product_barcodes')->select('status')->where('id', '=', $barcode_id)->first();

            if(!$status){
                $this->is_error = true;
                $this->errorMessage = 'No barcode found, Please try again!';
                return $this->errorMessage;
            }
            

            $user_id = Auth::user()->id;

            if($status->status == 'ADDED'){
                $this->is_error = true;
                $this->errorMessage = 'Already Added, cannot be added again! ' . $status->status;
                return $this->errorMessage;
                // throw new Error("Already Added, cannot be added again! {$status->status}");
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
                    'barcode_id' => $barcode_id,
                    'order_number' => 0,
                    'stocks' => 1,
                    'remarks' => "Added Stocks From scan barcode {$date_created}"
                ]);

                $this->is_success = true;
                return $this->successMessage = 'Barcode processed Successfully';
            }

       }catch(Throwable $e){
            $this->is_error = true;
            if ($e instanceof Exception) {
                // Handle Exception objects
                $this->errorMessage = $e->getMessage();
            } elseif ($e instanceof Error) {
                // Handle Error objects
                // Replace this with your own error handling logic
                $this->errorMessage = 'An error occurred';
            }
            // Re-throw the error to stop function execution
            throw $e;
       }
        
    }

    public function render()
    {

        $today = date('Ymd');

        return view('livewire.components.products.add-stock-barcode',[
            'barcodeLists' => ProductBarcode::where('product_barcodes.status', '=', 'ADDED')
            ->where(DB::raw('DATE(product_barcodes.updated_at)'), '=', $today)
            ->join('products', 'products.id', '=', 'product_barcodes.product_id')
            ->select(
                'product_barcodes.id',
                'product_barcodes.barcode',
                'products.model',
                'products.color',
                'products.size',
                'products.heel_height',
                'product_barcodes.updated_at'
            )
            ->groupBy(
                'product_barcodes.id',
                'product_barcodes.barcode',
                'products.model',
                'products.color',
                'products.size',
                'products.heel_height',
                'product_barcodes.updated_at'
            )
            ->paginate(10)
        ]);
    }
}
