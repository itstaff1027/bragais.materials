<div wire:poll.60s>
    <div class="p-0 w-full h-96 overflow-auto">
        <div class="flex flex-col justify-center items-center w-full">
            <div class="flex justify-center items-center bg-black text-white w-full p-2">
                <h1 class="text-xl font-serif">PENDING</h1>
            </div>
        
            <table class="table-fixed w-full text-center">
                <thead>
                    <tr>
                    @foreach ($table_header as $header)
                            <th>{{ $header['name'] }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $i => $order)
                        <tr key="{{ $i }}" class="{{ ($order['OrderType'] == 'MTO' || $order['Rush'] > 0) ? ($order['Rush'] > 0 ? 'bg-red-600' : 'bg-cyan-600') : 'bg-slate-500' }} text-white">
                            <td>{{ $order['OrderNo'] }}</td>
                            <td>{{ $order['OrderList'] }}</td>
                            <td>{{ $order['FName'] }} {{ $order['LName'] }}</td>
                            <td>{{ $order['Courier'] }}</td>
                            <td>{{ $order['DelNotes'] }}</td>
                            <td>PENDING</td>
                            <td>
                                <div class="flex flex-col">
                                    <button
                                        class="border-2 rounded-lg border-orange-500 font-medium hover:bg-orange-500"
                                        wire:click="store({{ json_encode($order) }})"
                                    > 
                                        PREPARING 
                                    </button>
                                    @if($order['Courier'] == 'STORE PICKUP')
                                    <button class="border-2 rounded-lg border-emerald-500 font-medium hover:bg-green-500"> 
                                        DONE 
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    
    <br>

    <div class="p-0 w-full h-96 overflow-auto">
        <div class="flex flex-col justify-center items-center w-full">
            <div class="flex justify-center items-center bg-orange-400 text-white w-full p-2">
                <h1 class="text-xl font-serif">PREPARING</h1>
            </div>
            
            <table class="table-fixed w-full text-center">
                <thead>
                    <tr>
                    @foreach ($table_header as $header)
                            <th>{{ $header['name'] }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($preparing_order as $i => $preparing)
                        @if ($preparing->status == 'PREPARING')
                        <tr key="{{ $i }}" class="{{ ($preparing->order_type == 'MTO' || $preparing->rush_fee > 0) ? ($preparing->rush_fee > 0 ? 'bg-red-600' : 'bg-cyan-600') : 'bg-slate-500' }} text-white">
                            <td>{{ $preparing->order_number }}</td>
                            <td>{{ $preparing->order_list }}</td>
                            <td>{{ $preparing->customer_name }}</td>
                            <td>{{ $preparing->courier }}</td>
                            <td>{{ $preparing->delivery_notes }}</td>
                            <td>PREPARING</td>
                            <td>
                                <div class="flex flex-col">
                                    <button
                                        class="border-2 rounded-lg border-orange-500 font-medium hover:bg-orange-500"
                                        wire:click="updateToPacked({{ $preparing->id }})"
                                    > 
                                        PACKED
                                    </button>
                                    {{-- @if($preparing['Courier'] == 'STORE PICKUP')
                                    <button class="border-2 rounded-lg border-emerald-500 font-medium hover:bg-green-500"> 
                                        DONE 
                                    </button>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
    
                </tbody>
            </table>
        </div>    
    </div>

    <br>

    <div class="p-0 w-full h-96 overflow-auto">
        <div class="flex flex-col justify-center items-center w-full">
            <div class="flex justify-center items-center bg-red-900 text-white w-full p-2">
                <h1 class="text-xl font-serif">PACKED</h1>
            </div>
            
            <table class="table-fixed w-full text-center">
                <thead>
                    <tr>
                    @foreach ($table_header as $header)
                            <th>{{ $header['name'] }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($packed_order as $i => $packed)
                        @if ($packed->status == 'PACKED')
                        <tr key="{{ $i }}" class="{{ ($packed->order_type == 'MTO' || $packed->rush_fee > 0) ? ($packed->rush_fee > 0 ? 'bg-red-600' : 'bg-cyan-600') : 'bg-slate-500' }} text-white">
                            <td>{{ $packed->order_number }}</td>
                            <td>{{ $packed->order_list }}</td>
                            <td>{{ $packed->customer_name }}</td>
                            <td>{{ $packed->courier }}</td>
                            <td>{{ $packed->delivery_notes }}</td>
                            <td>PACKED</td>
                            <td>
                                <div class="flex flex-col">
                                    <button
                                        class="border-2 rounded-lg border-orange-500 font-medium hover:bg-orange-500"
                                        wire:click="updateToShipped({{ $packed->id }})"
                                    > 
                                        SHIPPED
                                    </button>
                                    {{-- @if($packed['Courier'] == 'STORE PICKUP')
                                    <button class="border-2 rounded-lg border-emerald-500 font-medium hover:bg-green-500"> 
                                        DONE 
                                    </button>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        
    <br>

    <div class="p-0 w-full h-96 overflow-auto">
        <div class="flex flex-col justify-center items-center w-full">
            <div class="flex justify-center items-center bg-emerald-400 text-white w-full p-2">
                <h1 class="text-xl font-serif">SHIPPED/DONE</h1>
            </div>
            
            <table class="table-fixed w-full text-center">
                <thead>
                    <tr>
                    @foreach ($table_header as $header)
                            <th>{{ $header['name'] }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipped_order as $i => $shipped)
                        <tr key="{{ $i }}" class="{{ ($shipped->order_type == 'MTO' || $shipped->rush_fee > 0) ? ($shipped->rush_fee > 0 ? 'bg-red-600' : 'bg-cyan-600') : 'bg-slate-500' }} text-white">
                            <td>{{ $shipped->order_number }}</td>
                            <td>{{ $shipped->order_list }}</td>
                            <td>{{ $shipped->customer_name }}</td>
                            <td>{{ $shipped->courier }}</td>
                            <td>{{ $shipped->delivery_notes }}</td>
                            <td>SHIPPED</td>
                            <td>
                                <div class="flex flex-col">
                                    {{-- <button
                                        class="border-2 rounded-lg border-orange-500 font-medium hover:bg-orange-500"
                                        wire:click="updateToPacked({{ $shipped->order_number }})"
                                    > 
                                        PACKED
                                    </button> --}}
                                    {{-- @if($shipped['Courier'] == 'STORE PICKUP')
                                    <button class="border-2 rounded-lg border-emerald-500 font-medium hover:bg-green-500"> 
                                        DONE 
                                    </button>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
