<?php

namespace App\Livewire\Products;

use App\Livewire\Packaging\MaterialLogs;
use App\Models\PackagingMaterialLogs;
use Error;
use Livewire\Component;
use App\Models\Products;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesLog extends Component
{

    public $datas;
    public $paginatedItems;
    private $product_ids;
    private $order_number;
    public $date_today;

    public function mount(){
        $date_today = Date('Y-m-d');
        // dd($date_today);
        try {
            // Make the API request
            // $response = Http::withoutVerifying()->get($apiEndpoint);
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/saleslog.php?dateToday={$date_today}");
            // Check if the request was successful (status code 2xx)
            if ($response->ok()) {
                // Get the JSON response body as an associative array
                $data = $response->body(); // Use $response->json() directly
                $this->datas = json_decode($data, true);

                
            } else {
                // Handle non-successful response, e.g., 4xx or 5xx status codes
                $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
            }
        } catch (\Exception $e) {
            // Handle exceptions, e.g., connection errors
            $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
        }
    }

    public function getSalesLogs(){
        // $date_today = $this->date_today;
        // dd($this->date_today);
        try {
            // Make the API request
            // $response = Http::withoutVerifying()->get($apiEndpoint);
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/saleslog.php?dateToday={$this->date_today}");
            // Check if the request was successful (status code 2xx)
            if ($response->ok()) {
                // Get the JSON response body as an associative array
                $data = $response->body(); // Use $response->json() directly
                $this->datas = json_decode($data, true);
            } else {
                // Handle non-successful response, e.g., 4xx or 5xx status codes
                $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
            }
        } catch (\Exception $e) {
            // Handle exceptions, e.g., connection errors
            $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
        }
    }

    public function addToCompletePackaging($orderNo, $orderList){
        $this->order_number = $orderNo;

        $order_numberExist = PackagingMaterialLogs::where('order_number', intval($orderNo))->exists();

        if ($order_numberExist) {
            // Handle the case where the order number does not exist
            throw new Error('Already Added!');
        }

        $products = $this->getProductIDs($orderList);

        $user_id = Auth::user()->id;

        if(!$products){
            throw new Error('Unknow Products');
        }
        
        foreach($products as $product){
            DB::table('product_stocks')->insert([
                'user_id' => $user_id,
                'product_id' => $product['id'],
                'order_number' => $orderNo,
                'stocks' => -1,
                'remarks' => 'DEDUCT FOR COMPLETE PACKAGING',
                'status' => 'OUTGOING',
                'action' => 'DEDUCT'
            ]);

            if($product['category'] === "PAGEANT"){
            
                // TISSUE
                $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $product['id'], -1, 1, 'OUTGOING');
    
                if($product['model'] == 'KEVIN-V2'){
                    // PILLON
                    $this->insertCompletePackagingSale(1, $product['id'], -2, 1, 'OUTGOING');
    
                    if($product['size'] >= 9 && $product['size'] <= 12){
                        // Box
                        $this->insertCompletePackagingSale(11, $product['id'], -1, 1, 'OUTGOING');
                        // RIBBON
                        $this->insertCompletePackagingSale(19, $product['id'], (-1/15), 1, 'OUTGOING');
                    }
                    else{
                        // Box
                        $this->insertCompletePackagingSale(10, $product['id'], -1, 1, 'OUTGOING');
                        // RIBBON
                        $this->insertCompletePackagingSale(19, $product['id'], (-1/20), 1, 'OUTGOING');
                    }
                }
                else{
                    if($product['heel_height'] >= 8 and $product['heel_height'] <= 12){
                        // Box
                        $this->insertCompletePackagingSale(16, $product['id'], -1, 1, 'OUTGOING');
                        // PILON
                        $this->insertCompletePackagingSale(2, $product['id'], -2, 1, 'OUTGOING');
                        // RIBBON
                        $this->insertCompletePackagingSale(20, $product['id'], (-1/15), 1, 'OUTGOING');
                    }
                    else {
                        // Box
                        $this->insertCompletePackagingSale(16, $product['id'], -1, 1, 'OUTGOING');
                        // PILON
                        $this->insertCompletePackagingSale(2, $product['id'], -2, 1, 'OUTGOING');
                        // RIBBON
                        $this->insertCompletePackagingSale(20, $product['id'], (-1/20), 1, 'OUTGOING');
                    }
                    
                }
            }
    
            if($product['category'] === "HEELS"){
                // Box
                $this->insertCompletePackagingSale(15, $product['id'], -1, 1, 'OUTGOING');
                // PILON
                $this->insertCompletePackagingSale(3, $product['id'], -2, 1, 'OUTGOING');
                // RIBBON
                $this->insertCompletePackagingSale(20, $product['id'], (-1/20), 1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                // DUST BAG
                $this->insertCompletePackagingSale(8, $product['id'], -1, 1, 'OUTGOING');
            }
    
            if($product['category'] === "MANDIATOR"){
                // Box
                $this->insertCompletePackagingSale(21, $product['id'], -1, 1, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(4, $product['id'], -1, 1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(6, $product['id'], -1, 1, 'OUTGOING');
            }
    
            if($product['category'] === "WONDIATOR"){
                // Box
                $this->insertCompletePackagingSale(22, $product['id'], -1, 1, 'OUTGOING');
                // LL PILON
                $this->insertCompletePackagingSale(4, $product['id'], -1, 1, 'OUTGOING');
                // TISSUE
                $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                // ll DUST BAG
                $this->insertCompletePackagingSale(7, $product['id'], -1, 1, 'OUTGOING');
            }
        }
        
    }

    private function getProductIDs($orderList){
        if(!$orderList){
            throw new Error('Unknown Array');
        }

        $lists = explode(',', $orderList);
        $disperseOrdersArray = array();
        
        // dd($lists);
        foreach($lists as $list){
            $parts = explode(' ', $list);
            // dd($parts);
            // Extract the numeric value from the last part
            if(count($parts) == 4){
                $lastPart = end($parts);
                preg_match('/\d+/', $lastPart, $matches);
                $numericValue = isset($matches[0]) ? $matches[0] : null;
            }
            else{
                $numericValue = 0;
            }
            
            // dd($numericValue);
            $checkProduct = DB::table('products')->where('model', '=', "{$parts[0]}")->where('color', '=', "{$parts[1]}")
            ->exists();
            
            if($checkProduct){
                // Store the disperse orders in an associative array
                $disperseOrders = array(
                    'model' => $parts[0],        // assuming 'KEVIN-V2' is the model
                    'color' => $parts[1],        // assuming 'NUDE-GLOSSY' is the color
                    'size' => $parts[2],         // assuming '7' is the size
                    'heel_height' => $numericValue, // assuming '6' is the numeric value from the last part
                );
                // dd($disperseOrders);
                $product = DB::table('products')->where('model', '=', "{$disperseOrders['model']}")
                ->where('color', '=', "{$disperseOrders['color']}")
                ->where('size', '=', $disperseOrders['size'])
                ->where('heel_height', '=', $disperseOrders['heel_height'])
                ->first();
            
                // dd($product);

                // Append the current order to the results array
                $disperseOrdersArray[] = [
                    'id' => $product->id,
                    'product_sku' => $product->product_sku,
                    'model' => $product->model,        
                    'color' => $product->color,        
                    'size' => $product->size,         
                    'heel_height' => $product->heel_height,
                    'category' => $product->category
                ];
            }
        }

        return $disperseOrdersArray;

    }

    private function insertCompletePackagingSale($material_id, $product_id, $stocks, $quantity, $status){

        $totalStocks = $this->getTotalDeduction($stocks, $quantity);

        DB::table('packaging_material_logs')->insert([
            'packaging_material_id' => $material_id,
            'product_id' => $product_id,
            'order_number' => $this->order_number,
            'stocks' => $totalStocks,
            'quantity' => $quantity,
            'status' => $status
        ]);
    }

    private function getTotalDeduction($numberOfDeduction, $quantity){
        $computedDeduction = 0;
        $quantity == 1 ? $computedDeduction = $numberOfDeduction : $computedDeduction = $quantity * $numberOfDeduction;
        return $computedDeduction;
    }

    public function addDeliveredOrders($orderNumber, $orderLists, $closedSaleDate){

        // dd($closedSaleDate);

        $order_numberExist = DB::table('outgoing_product_logs')->where('order_number', intval($orderNumber))->exists();

        if ($order_numberExist) {
            // Handle the case where the order number does not exist
            throw new Error('Already Added!');
        }

        $products = $this->getProductIDs($orderLists);

        foreach($products as $product){
            DB::table('outgoing_product_logs')->insert([
                'product_id' => $product['id'],
                'order_number' => $orderNumber,
                'quantity' => 1,
                'status' => 'DELIVERED',
                'closed_sale_date' => $closedSaleDate
            ]);
        }

        return redirect('/products');

    }

    public function render()
    {

        return view('livewire.products.sales-log', [
            'orders' => $this->datas
        ]);
    }
    
}
