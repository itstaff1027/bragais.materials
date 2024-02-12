<?php

namespace App\Livewire\Products;

use Error;
use Exception;
use Livewire\Component;
use App\Models\Products;
use PhpParser\JsonDecoder;
use Livewire\Attributes\Title;
use App\Exports\SalesLogExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PackagingMaterialLogs;
use App\Livewire\Packaging\MaterialLogs;
use App\Models\ProductStocks;
use Illuminate\Pagination\LengthAwarePaginator;

#[Title('Sales')]
class SalesLog extends Component
{

    public $datas;
    public $paginatedItems;
    private $product_ids;
    private $order_number;
    public $date_today;
    public $get_order_number;
    public $year = '2024';
    public $month = 1;

    public $dataMonthly;

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

    public function getOrder(){
        // $date_today = $this->date_today;
        // dd($this->date_today);
        try {
            // Make the API request
            // $response = Http::withoutVerifying()->get($apiEndpoint);
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_order.php?orderNumber={$this->get_order_number}");
            // Check if the request was successful (status code 2xx)
            if ($response->ok()) {
                // Get the JSON response body as an associative array
                $data = $response->body(); // Use $response->json() directly
                $this->datas = json_decode($data, true);
                // dd($this->datas);
            } else {
                // Handle non-successful response, e.g., 4xx or 5xx status codes
                $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
            }
        } catch (\Exception $e) {
            // Handle exceptions, e.g., connection errors
            $this->datas = []; // Set $this->datas to an empty array or handle the error as needed
        }
    }

    public function getDataMonthly(){
        $this->dataMonthly = [];
    
        try {
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_sales_monthly.php?year={$this->year}&month={$this->month}");
    
            if ($response->ok()) {
                $data = $response->body();
                error_log("Response Body: " . $data);
                $dataMonthly = json_decode($data, true);
    
                if ($dataMonthly !== null && json_last_error() === JSON_ERROR_NONE) {
                    $itemList = [];
                    $bus = 0;
                    $fedex = 0;
                    $lbcdtd = 0;
                    $lbcpu = 0;
                    $pal = 0;
                    $storePickUp = 0;
                    $storeSales = 0;
                    $lalamove = 0;
    
                    foreach ($dataMonthly as $item) {

                        // Use associative keys to access values
                        $orderList = explode(',', $item['OrderList']);
                        $clean = array_filter($orderList);
                        $reIndexedOrderList = array_values($clean);

                        foreach ($reIndexedOrderList as $order) {
                            // Log the order number or any unique identifier associated with the item
                            error_log("Processing order number: " . $item['OrderNo']);
                            // error_log("Response Body: " . json_encode($item));
                            // error_log("Response Body: " . $order);
                            $parts = explode(' ', $order);
                            $cleanParts = array_filter($parts);
                            $reIndexedParts = array_values($cleanParts);
                            // dd($reIndexedParts);
                            if (count($parts) <= 0) {
                                throw new Exception("Invalid order format: " . $order);
                            }

                            $checkProduct = DB::table('products')
                                ->where('model', '=', $reIndexedParts[0])
                                ->where('color', '=', $reIndexedParts[1])
                                ->exists();

                            if ($checkProduct) {
                                switch ($item['Courier']) {
                                    case 'BUS':
                                        $bus++;
                                        break;
                                    case 'FEDEX':
                                        $fedex++;
                                        break;
                                    case 'LBCDTD':
                                        $lbcdtd++;
                                        break;
                                    case 'LBCPU':
                                        $lbcpu++;
                                        break;
                                    case 'PAL':
                                        $pal++;
                                        break;
                                    case 'LALAMOVE':
                                        $lalamove++;
                                        break;
                                    case 'STORE PICKUP':
                                        if ($item['Sale'] == 'ONLINE') {
                                            $storePickUp++;
                                        } else {
                                            $storeSales++;
                                        }
                                        break;
                                }
                            }
                        }
                    }

    
                    $itemList[] = [
                        'BUS' => $bus,
                        'FEDEX' => $fedex,
                        'LBCDTD' => $lbcdtd,
                        'LBCPU' => $lbcpu,
                        'PAL' => $pal,
                        'LALAMOVE' => $lalamove,
                        'STORE PICKUP' => $storePickUp,
                        'STORE SALES' => $storeSales
                    ];
    
                    $this->dataMonthly = $itemList;
                    dd($itemList);
                } else {
                    throw new Error("Error decoding JSON: " . json_last_error_msg());
                }
            } else {
                throw new Error("Non-successful HTTP response: " . $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            error_log("An error occurred: " . $e->getMessage());
            // You can echo the error message or handle it in any other way you prefer
            echo "An error occurred: " . $e->getMessage();
        }
    }

    // public function getAllItems(){
    //     $this->dataMonthly = [];
    //     try {
    //         $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_sales_monthly.php?year={$this->year}&month={$this->month}");
    
    //         if ($response->ok()) {
    //             $data = $response->body();
    //             error_log("Response Body: " . $data);
    //             $dataMonthly = json_decode($data, true);
    
    //             if ($dataMonthly !== null && json_last_error() === JSON_ERROR_NONE) {
    //                 $itemCounts = [];
    //                 $totalItemCount = 0;
    
    //                 foreach ($dataMonthly as $item) {
    //                     $orderList = explode(',', $item['OrderList']);
    //                     $cleanOrderList = array_filter($orderList);
    //                     foreach ($cleanOrderList as $order) {
    //                         // Extracting the full item name
    //                         $fullItemName = trim($order);
    //                         if (isset($itemCounts[$fullItemName])) {
    //                             $itemCounts[$fullItemName]++;
    //                         } else {
    //                             $itemCounts[$fullItemName] = 1;
    //                         }
    //                         $totalItemCount++;
    //                     }
    //                 }
    //                 dd($itemCounts);
    
    //                 // Output item counts
    //                 foreach ($itemCounts as $itemName => $count) {
    //                     error_log("Item: $itemName, Count: $count");
    //                 }
    
    //                 // Output total count
    //                 error_log("Total Count of All Items: $totalItemCount");
    //             } else {
    //                 throw new Error("Error decoding JSON: " . json_last_error_msg());
    //             }
    //         } else {
    //             throw new Error("Non-successful HTTP response: " . $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         // Handle exceptions
    //         error_log("An error occurred: " . $e->getMessage());
    //         // You can echo the error message or handle it in any other way you prefer
    //         echo "An error occurred: " . $e->getMessage();
    //     }
    // }

    // public function getAllItems(){
    //     $this->dataMonthly = [];
    //     try {
    //         $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_sales_monthly.php?year={$this->year}&month={$this->month}");
    
    //         if ($response->ok()) {
    //             $data = $response->body();
    //             error_log("Response Body: " . $data);
    //             $dataMonthly = json_decode($data, true);
    
    //             if ($dataMonthly !== null && json_last_error() === JSON_ERROR_NONE) {
    //                 $itemCounts = [];
    //                 $totalItemCount = 0;
    
    //                 foreach ($dataMonthly as $item) {
    //                     $orderList = explode(',', $item['OrderList']);
    //                     $cleanOrderList = array_filter($orderList);
    //                     foreach ($cleanOrderList as $order) {
    //                         // Extracting only the design (model) part of the item name
    //                         if (preg_match('/^([^\s]+)/', $order, $matches)) {
    //                             $design = trim($matches[0]);
    //                             if (isset($itemCounts[$design])) {
    //                                 $itemCounts[$design]++;
    //                             } else {
    //                                 $itemCounts[$design] = 1;
    //                             }
    //                             $totalItemCount++;
    //                         } else {
    //                             // Skip items not matching the specified format
    //                             continue;
    //                         }
    //                     }
    //                 }
    //                 dd($itemCounts);
    //                 // Output item counts
    //                 foreach ($itemCounts as $design => $count) {
    //                     error_log("Design: $design, Count: $count");
    //                 }
    
    //                 // Output total count
    //                 error_log("Total Count of All Designs: $totalItemCount");
    //             } else {
    //                 throw new Error("Error decoding JSON: " . json_last_error_msg());
    //             }
    //         } else {
    //             throw new Error("Non-successful HTTP response: " . $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         // Handle exceptions
    //         error_log("An error occurred: " . $e->getMessage());
    //         // You can echo the error message or handle it in any other way you prefer
    //         echo "An error occurred: " . $e->getMessage();
    //     }
    // }

    public function getAllItems(){
        $this->dataMonthly = [];
        try {
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_sales_monthly.php?year={$this->year}&month={$this->month}");
    
            if ($response->ok()) {
                $data = $response->body();
                error_log("Response Body: " . $data);
                $dataMonthly = json_decode($data, true);
    
                if ($dataMonthly !== null && json_last_error() === JSON_ERROR_NONE) {
                    $itemCounts = [];
    
                    foreach ($dataMonthly as $item) {
                        $orderList = explode(',', $item['OrderList']);
                        $cleanOrderList = array_filter($orderList);
                        foreach ($cleanOrderList as $order) {
                            // Splitting the item name by spaces
                            $parts = explode(' ', $order);
                            // Extracting the design and heel height from the first two parts
                            if (count($parts) >= 4) {
                                $design = trim($parts[0]);
                                $heelHeight = trim($parts[3]);
                                $key = "$design|$heelHeight";
                                if (isset($itemCounts[$key])) {
                                    $itemCounts[$key]++;
                                } else {
                                    $itemCounts[$key] = 1;
                                }
                            } else {
                                // Skip items with invalid format
                                continue;
                            }
                        }
                    }
                    dd($itemCounts);
                    // Output item counts
                    foreach ($itemCounts as $combination => $count) {
                        list($design, $heelHeight) = explode('|', $combination);
                        error_log("Design: $design, Heel Height: $heelHeight, Count: $count");
                    }
                } else {
                    throw new Error("Error decoding JSON: " . json_last_error_msg());
                }
            } else {
                throw new Error("Non-successful HTTP response: " . $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            error_log("An error occurred: " . $e->getMessage());
            // You can echo the error message or handle it in any other way you prefer
            echo "An error occurred: " . $e->getMessage();
        }
    }

    public function getItemsWithCustomer(){
        $this->dataMonthly = [];
        try {
            $response = Http::connectTimeout(3)->withoutVerifying()->get("https://shoecietyinc.com/api/sales/get_sales_with_customer.php?year={$this->year}");
    
            if ($response->ok()) {
                $data = $response->body();
                error_log("Response Body: " . $data);
                $dataMonthly = json_decode($data, true);
    
                if ($dataMonthly !== null && json_last_error() === JSON_ERROR_NONE) {
                    $items = [];
                    foreach ($dataMonthly as $item) {
                        $orderList = explode(',', $item['OrderList']);
                        // dd($item);
                        $cleanOrderList = array_filter($orderList);
                        $itemCounts = [];
                        foreach ($cleanOrderList as $order) {
                            // Extracting the full item name
                            $fullItemName = trim($order);
                            if (isset($itemCounts[$fullItemName])) {
                                $itemCounts[$fullItemName]['count']++;
                            } else {
                                $itemCounts[$fullItemName] = [
                                    'count' => 1,
                                ];
                            }
                        }
                        foreach ($itemCounts as $name => $counts) {
                            $items[] = [
                                'name' => $name,
                                'count' => $counts['count'],
                                'order_number' => $item['OrderNo'],
                                'timestamp' => $item['timestamp'],
                                'agent_number' => $item['AgentNo'],
                                'customer_id' => $item['customerID'],
                                'total_quantity' => $item['Qty'],
                                'total_price' => $item['TotalPrice'],
                                'paid' => $item['Paid'],
                                'discount' => $item['Discount'],
                                'balance' => $item['Balance'],
                                'excess' => $item['Excess'],
                                'mode_of_payment' => $item['MOP'],
                                'packaging_type' => $item['Packaging'],
                                'delivery_type' => $item['DelToScout'],
                                'shipping_fee' => $item['sf'],
                                'rush_fee' => $item['Rush'],
                                'sold_from' => $item['Sale'],
                                'social_media' => $item['FBIG']
                            ];
                        }
                    }

                    // dd($items);
                    // $this->dataMonthly = $items;
                    return $items;
    
                    // Output item counts
                    // foreach ($itemCounts as $itemName => $count) {
                    //     error_log("Item: $itemName, Count: $count");
                    // }
                } else {
                    throw new Error("Error decoding JSON: " . json_last_error_msg());
                }
            } else {
                throw new Error("Non-successful HTTP response: " . $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            error_log("An error occurred: " . $e->getMessage());
            // You can echo the error message or handle it in any other way you prefer
            echo "An error occurred: " . $e->getMessage();
        }
    }

    public function export() {
        $data = $this->getItemsWithCustomer();

        // dd($data);
        return Excel::download(new SalesLogExport($data, $this->year), "$this->year.xlsx");
    }
    
    public function addToCompletePackaging($orderNo, $orderList, $packagingType, $soldFrom, $is_replacement){
        $this->order_number = $orderNo;
        $order_numberExist = '';

        // if($soldFrom == 'PULLOUT'){
        //     throw new Error("This order Type cannot be added ! {$soldFrom}");
        // }

        // if($packagingType == 'DUSTBAG ONLY'){
        //     throw new Error('This order is Dustbag Only!');
        // }

        // if($packagingType == 'NO PACKAGING'){
        //     throw new Error('This order is NO PACKAGING!');
        // }

        if(!$is_replacement){
            $order_numberExist = PackagingMaterialLogs::where('order_number', intval($orderNo))->exists();
        }

        // ADD COLUMN IN DATABSE is_replacement in product_stocks
        if($is_replacement){
            $order_numberExist = DB::table('product_stocks')->where('order_number', intval($orderNo))->where('is_replacement', '=', 'YES')->exists();
            if(!$order_numberExist){
                $products = ProductStocks::where('order_number', intval($orderNo))->where('is_replacement', '<>', 'YES')->get();
                // dd($products);
                foreach($products as $product){
                    $product->status = 'INCOMING';
                    $product->stocks = -($product->stocks);
                    $product->is_replacement = 'YES';
                    $product->save();
                }
                
            }
        }

        if ($order_numberExist) {
            // Handle the case where the order number does not exist
            throw new Error('Already Added!');
        }

        $products = $this->getProductIDs($orderList);

        $user_id = Auth::user()->id;

        if(!$products){
            throw new Error('Unknow Products');
        }
        
        // ADD COLUMN IN PRODUCTION ORDER TYPE
        foreach($products as $product){
            DB::table('product_stocks')->insert([
                'user_id' => $user_id,
                'product_id' => $product['id'],
                'order_number' => $orderNo,
                'stocks' => -1,
                'remarks' => "DEDUCT - {$packagingType}",
                'status' => 'OUTGOING',
                'action' => 'DEDUCT',
                'order_from' => $soldFrom,
                'is_replacement' => $is_replacement ? 'YES' : ''
            ]);
            

            if($packagingType == 'DUSTBAG ONLY'){
                if($product['category'] == 'PAGEANT'){
                    $this->insertCompletePackagingSale(8, $product['id'], -1, 1, 'OUTGOING');
                }
                if($product['category'] == 'HEELS'){
                    $this->insertCompletePackagingSale(8, $product['id'], -1, 1, 'OUTGOING');
                }
                if($product['category'] == 'MANDIATOR'){
                    // ll DUST BAG
                    $this->insertCompletePackagingSale(6, $product['id'], -1, 1, 'OUTGOING');
                }
                if($product['category'] == 'WONDIATOR'){
                    // ll DUST BAG
                    $this->insertCompletePackagingSale(7, $product['id'], -1, 1, 'OUTGOING');
                }
            }

            if($packagingType == 'ORDINARY PACKAGING NO DUSTBAG'){
                if($product['category'] === "PAGEANT"){
                
                    // TISSUE
                    $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
        
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
                }
        
                if($product['category'] === "MANDIATOR"){
                    // Box
                    $this->insertCompletePackagingSale(21, $product['id'], -1, 1, 'OUTGOING');
                    // LL PILON
                    $this->insertCompletePackagingSale(4, $product['id'], -1, 1, 'OUTGOING');
                    // TISSUE
                    $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                }
        
                if($product['category'] === "WONDIATOR"){
                    // Box
                    $this->insertCompletePackagingSale(22, $product['id'], -1, 1, 'OUTGOING');
                    // LL PILON
                    $this->insertCompletePackagingSale(4, $product['id'], -1, 1, 'OUTGOING');
                    // TISSUE
                    $this->insertCompletePackagingSale(18, $product['id'], -1, 1, 'OUTGOING');
                }
            }

            if($packagingType == 'COMPLETE PACKAGING'){
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
        
    }

    private function getProductIDs($orderList){
        if(!$orderList){
            throw new Error('Unknown Array');
        }

        $lists = explode(',', $orderList);
        // Remove empty elements
        $lists = array_filter($lists);
        // Optional: Re-index the array to start from index 0
        $lists = array_values($lists);

        $disperseOrdersArray = array();
        
        // dd($lists);
        foreach($lists as $list){
            $parts = explode(' ', $list);
            // Remove empty elements
            $parts = array_filter($parts);
            // Optional: Re-index the array to start from index 0
            $parts = array_values($parts);
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

    public function addDeliveredOrders($orderNumber, $orderLists, $closedSaleDate, $soldFrom, $courier){

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
                'order_from' => $soldFrom,
                'quantity' => 1,
                'status' => 'DELIVERED',
                'closed_sale_date' => $closedSaleDate,
                'courier' => $courier
            ]);
        }

    }

    

    public function render()
    {
        $data = [];
        if($this->dataMonthly){
            $data = $this->dataMonthly;
        }

       return view('livewire.products.sales-log', [
            'orders' => $this->datas,
            // 'orders_saleslog' => $data,
        ]);
    }
    
}
