<div x-data="{ open: false }">
    <div class="flex w-full p-2 mb-4">
        <a href="{{ route('generate-pdf') }}" class="border-2 p-2 mr-2 rounded-md border-blue-400">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
            </button>
        </a>
        <button class="border-2 p-2 mr-2 rounded-md border-blue-400" wire:click='export'> CSV </button>
        <input type="text" class="w-full rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='first_range_date' placeholder="DATE-FIRST : FORMAT [y-m-d]" />
        <input type="text" class="w-full rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='second_range_date' placeholder="DATE-SECOND : FORMAT [y-m-d]" />
        <input type="text" class="w-full rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='month' placeholder="MONTH: FORMAT [1 or 01]" />
        <button class="rounded-r-md border-2 border-blue-400 border-l-1 p-2" @click="open = ! open">Range</button>

    </div>

    <div class="w-full flex flex-col items-end justify-end" x-show="open" x-transition.duration.500ms>
        {{-- <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='first_range_date' placeholder="DATE-FIRST : FORMAT [y-m-d]" />
        <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='second_range_date' placeholder="DATE-SECOND : FORMAT [y-m-d]" /> --}}
    </div>
    <div class="overflow-x-auto w-full">
        <table class="table-fixed table-y-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400" lazy>
            <caption>
                <h1 class="font-bold text-2xl">Summary</h1>
            </caption>
            <thead>
                <tr>
                    <th class="w-36"># Dates</th>
                    @foreach ($dates as $date)
                        <th colspan="2" class="bg-orange-500 border w-28">{{ $date->date }}</th>
                    @endforeach
                    <th colspan="3"  class="bg-gray-500 w-40">Total</th>
                </tr>
                <tr>
                    <th class="w-50">Names</th>
                    @foreach ($dates as $date)
                        <th class="bg-emerald-500 w-28">+</th>
                        <th class="bg-red-500 w-28">-</th>
                    @endforeach
                    <th class="bg-emerald-500 w-28">+</th>
                    <th class="bg-red-500 w-28">-</th>
                    <th class="bg-blue-500 w-28">+-</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // $reArrays = array();

                    // foreach($products as $product){
                    //     $productStocks = [];

                    //     foreach($dates as $date){
                    //         $dateStock = [
                    //             'date' => $date->date,
                    //             'incoming' => '',
                    //             'outgoing' => ''
                    //         ];

                    //         foreach($stocks as $stock){
                    //             if($stock->product_id == $product->id && $stock->date == $date->date){
                    //                 if($stock->status == 'INCOMING'){
                    //                     $dateStock['incoming'] = $stock->stocks;
                    //                 } elseif ($stock->status == 'OUTGOING') {
                    //                     $dateStock['outgoing'] = $stock->stocks;
                    //                 }
                    //             }
                    //         }

                    //         $productStocks[] = $dateStock;
                    //     }

                    //     $reArrays[] = [
                    //         'id' => $product->id,
                    //         'product_sku' => $product->product_sku,
                    //         'model' => $product->model,
                    //         'color' => $product->color,
                    //         'size' => $product->size,
                    //         'heel_height' => $product->heel_height,
                    //         'stocks' => $productStocks
                    //     ];
                    // }
                    // foreach($products as $product){
                    //     $reArrays[] = [
                    //         'id' => $product->id,
                    //         'product_sku' => $product->product_sku,
                    //         'model' => $product->model,
                    //         'color' => $product->color,
                    //         'size' => $product->size,
                    //         'heel_height' => $product->heel_height,
                    //         'stocks' => [] // Initialize stocks array for the product
                    //     ];

                    //     foreach($stocks as $stock){
                    //         if($stocks->product_id == $product->id){
                    //             $reArrays[count($reArrays) - 1]['stocks'][] = [
                    //                 'date' => $stock->date,
                    //                 'incoming' => $stock->incoming ?: '',
                    //                 'outgoing' => $stock->outgoing ?: ''
                    //             ];
                    //         }
                    //     }
                    // }

                @endphp
                
                {{-- @foreach ($newArray as $products)
                    @php
                        $totalIncoming = 0;
                        $totalOutgoing = 0;
                    @endphp
                    <tr>
                        <td class="border-2">{{ $products['product_sku'] }}</td>
                        @foreach ($products['stocks'] as $stocks)
                            @php
                                $totalIncoming += $stocks['incoming'];
                                $totalOutgoing += $stocks['outgoing'];
                            @endphp
                            <td class="border-2 font-bold {{ $stocks['incoming'] == 0 ? "text-orange-900" : "text-emerald-600" }} ">{{ $stocks['incoming'] }}</td>
                            <td class="border-2 font-bold {{ $stocks['outgoing'] == 0 ? "text-orange-900" : "text-emerald-600" }} ">{{ $stocks['outgoing'] }}</td>
                        @endforeach
                        <td class="border-2 font-bold {{ $totalIncoming == 0 ? "text-orange-900" : "text-emerald-600" }} ">{{ $totalIncoming }}</td>
                        <td class="border-2 font-bold {{ $totalOutgoing == 0 ? "text-orange-900" : "text-emerald-600" }} ">{{ $totalOutgoing }}</td>
                        <td class="border-2 font-bold text-blue-500 ">{{ $totalIncoming + $totalOutgoing }}</td>
                    </tr>
                @endforeach --}}
                {{-- @foreach ($reArrays as $products)
                    <tr>
                        <td class="border-2">{{ $products['product_sku'] }}</td>
                        @foreach ($products['stocks'] as $stocks)
                            <td class="border-2">{{ $stocks['incoming'] }}</td>
                            <td class="border-2">{{ $stocks['outgoing'] }}</td>
                        @endforeach
                    </tr>
                @endforeach --}}
                @foreach ($products as $product)
                    
                    @php
                    // dd($product);
                        $totalIncoming = 0;
                        $totalOutgoing = 0;
                    @endphp
                    <tr class="border-2">
                        <td class="border-2">{{ $product->product_sku }}</td>

                        @foreach ($dates as $date)
                            @php
                                $incoming = 0;
                                $outgoing = 0;
                            @endphp
                            @foreach ($stocks as $stock)
                                @if ($stock->date == $date->date && $stock->product_id == $product->id)
                                    @if ($stock->status == 'INCOMING')
                                        @php
                                            $incoming += $stock->stocks; // Increment incoming stocks
                                            $totalIncoming += $stock->stocks;
                                        @endphp
                                    @elseif ($stock->status == 'OUTGOING')
                                        @php
                                            $outgoing += $stock->stocks; // Increment outgoing stocks
                                            $totalOutgoing += $stock->stocks;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            @if ($incoming)
                                <td class="border-2">{{ $incoming }}</td>
                            @else
                                <td class="border-2"></td>
                            @endif
                            @if($outgoing)
                                <td class="border-2">{{ $outgoing ? $outgoing : '' }}</td>
                            @else
                                <td class="border-2"></td>
                            @endif
                        @endforeach
                        <td class="border-2">{{ $totalIncoming }}</td>
                        <td class="border-2">{{ $totalOutgoing }}</td>
                        <td>{{ $product->total_stocks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">
            {{ $products->links() }}
        </div>
        {{-- <form wire:submit="fetchData" class="m-8">
            <!-- ... -->

            <div wire:loading>
                Summarizing...
            </div>

            <button type="submit" class="w-full rounded-md bg-emerald-200 p-4 hover:bg-emerald-600">Get Summary</button>
        </form> --}}
    </div>
</div>
