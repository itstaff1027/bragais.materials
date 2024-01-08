<?php

namespace App\Livewire\Products;

use App\Models\TemporaryDeliveryLogs;
use Livewire\Component;
use Livewire\Attributes\Title;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

#[Title('Delivery - Logs')]
class DeliveryLog extends Component
{

    public $table_header = [
        ['name' => 'Order Number'],
        ['name' => 'Order Lists'],
        ['name' => 'Customer'],
        ['name' => 'Courier'],
        // ['name' => 'Remarks'],
        ['name' => 'Delivery Notes'],
        ['name' => 'Status'],
        ['name' => 'Actions']
    ];
    public $datas;
    public $date_today;
    public $orders = [];

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

    public function store($order){

        $exist = TemporaryDeliveryLogs::where('order_number', '=', $order['OrderNo'])->first();

        if($exist){
            throw new Error('ALREADY ADDED');
        }

        $customerName = $order['FName'] . ' ' . $order['LName'];

        TemporaryDeliveryLogs::insert([
            'order_number' => $order['OrderNo'],
            'order_list' => $order['OrderList'],
            'customer_name' => $customerName,
            'courier' => $order['Courier'],
            'rush_fee' => $order['Rush'],
            'sold_from' => $order['Sale'],
            'order_type' => $order['OrderType'],
            'remarks' => $order['Remarks'],
            'delivery_notes' => $order['DelNotes'],
            'status' => 'PREPARING'
        ]);

    }

    public function updateToPacked($orderNumber){
        $deliveryLogs = TemporaryDeliveryLogs::find($orderNumber);

        $deliveryLogs->status = 'PACKED';
        $deliveryLogs->save();

        // return redirect('/products/delivery-logs');
    }

    public function updateToShipped($orderNumber){
        $deliveryLogs = TemporaryDeliveryLogs::find($orderNumber);

        $deliveryLogs->status = 'SHIPPED';
        $deliveryLogs->save();

        // return redirect('/products/delivery-logs');
    }

    public function render()
    {
        $this->orders = [];
        // dd($this->datas);

        $date = Date('Y-m-d');

        foreach($this->datas as $order){
            if($order['Sale'] == 'ONLINE'){
                $this->orders[] = $order;
            }
        }

        $statusOrder = TemporaryDeliveryLogs::all();
        $shippedOrder = TemporaryDeliveryLogs::whereDate(DB::raw('DATE(updated_at)'), '=', $date)->where('status', '=', 'SHIPPED')->get();

        return view('livewire.products.delivery-log', [
            'table_header' => $this->table_header,
            'orders' => $this->orders,
            'preparing_order' => $statusOrder,
            'packed_order' => $statusOrder,
            'shipped_order' => $shippedOrder,
        ]);
    }
}
