<div>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Packaging Summary') }}
                </h2>
                {{-- <a href="{{ route('packaging-per-day') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Per Day') }}
                </a>
                <a href="{{ route('summary') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Summary') }}
                </a>
                <a href="{{ route('material-logs') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Material Logs') }}
                </a> --}}
            </div>
            
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900"  x-data="{ open: false }">
                        <div class="flex w-full p-2 mb-4">
                            <a href="{{ route('generate-pdf') }}" class="border-2 p-2 mr-2 rounded-md border-blue-400">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                </button>
                            </a>
                            <button class="border-2 p-2 mr-2 rounded-md border-blue-400" wire:click='export'> CSV </button>
                            <input type="text" class="w-full rounded-l-md border-2 border-blue-400 border-r-0"  wire:model.live.debounce.500ms='filter_date' placeholder="Search by DATE : FORMAT [y-m-d]" />

                            <button class="rounded-r-md border-2 border-blue-400 border-l-1 p-2" @click="open = ! open">Filter</button>
                            
                        </div>

                        <div class="w-full flex flex-col items-end justify-end" x-show="open" x-transition.duration.500ms>
                            <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='filter_date_range_first' placeholder="DATE-FIRST : FORMAT [y-m-d]" />
                            <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='filter_date_range_second' placeholder="DATE-SECOND : FORMAT [y-m-d]" />
                        </div>
                        <div class="w-full overflow-x-auto">
                            <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
                                <caption>
                                    <h1 class="font-bold text-2xl">Summary</h1>
                                </caption>
                                <thead>
                                    <tr>
                                        <th># Dates</th>
                                        @foreach ($dates as $date)
                                            <th colspan="2" class="bg-orange-500 border">{{ $date->date }}</th>
                                        @endforeach
                                        <th colspan="3"  class="bg-gray-500">Total</th>
                                    </tr>
                                    <tr>
                                        <th>Names</th>
                                        @foreach ($dates as $date)
                                            <th class="bg-emerald-500">Add</th>
                                            <th class="bg-red-500">Rel.</th>
                                        @endforeach
                                        <th class="bg-emerald-500">Add</th>
                                        <th class="bg-red-500">Rel.</th>
                                        <th class="bg-blue-500">Rem.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materials as $material)
                                        <tr class="border">
                                            <td>{{ $material->name }} : {{ $material->size }}</td>
                                            @php
                                                $incomingStockSum = 0;
                                                $outgoingStockSum = 0;
                                                $remainingStocks = 0;
                                            @endphp

                                                {{-- This is to get the total remaining stocks so that it will not affect --}}
                                                {{-- the filter's computation --}}
                                            @php
                                                foreach ($getMaterialStocks as $stock) {

                                                    if ($stock->packaging_material_id == $material->id ) {
                                                        $remainingStocks += $stock->total_stocks;
                                                    }
                                                } 
                                            @endphp

                                            {{-- it will loop base on the date as well as the stocks --}}

                                            @foreach ($dates as $date)
                                                @php
                                                    $incomingStock = 0;
                                                    $outgoingStock = 0;
                                                    
                                                    // OVERALL - SET ZERO
                                                    // whtie
                                                    $total_white_ribbon_large = 0;
                                                    $total_white_ribbon_medium = 0;
                                                    // brown
                                                    $total_brown_ribbon_large = 0;
                                                    $total_brown_ribbon_medium = 0;
                                                    $total_brown_ribbon_small = 0;
                                                    $total_white_ribbon = 0;
                                                    $total_brown_ribbon = 0;
                                                    // Deducted Ribbon
                                                    $total_brown_ribbon_deducted = 0;
                                                    $total_white_ribbon_deducted = 0;

                                                    // ITERATE OVER THE DATA:getTotalRibbon TO GET THE TOTAL AMOUNT OF OUTGOING MATERIALS IN 19 || 20
                                                    foreach ($getTotalRibbon as $total_ribbon){
                                                        // check if the $dates is = to the $total_ribbon->date for accurate computation
                                                        if ($date->date == $total_ribbon->ribbon_date && $material->id == 19 || $material->id == 20){
                                                            if($date->date == $total_ribbon->ribbon_date){
                                                                if($total_ribbon->category == 'PAGEANT'){
                                                                    if($total_ribbon->name == "WHITE_RIBBON"){
                                                                        if($total_ribbon->size >= 9 && $total_ribbon->size <= 12 || $total_ribbon->size >= 39 && $total_ribbon->size <= 42){
                                                                            $total_white_ribbon_large = $total_white_ribbon_large + $total_ribbon->material_stocks;
                                                                        }
                                                                        else{
                                                                            $total_white_ribbon_medium = $total_white_ribbon_medium + $total_ribbon->material_stocks;
                                                                        }
                                                                    }
                                                                    else{
                                                                        if($total_ribbon->name == "BROWN_RIBBON"){
                                                                            if($total_ribbon->heel_height >= 8 && $total_ribbon->heel_height <= 12){
                                                                                $total_brown_ribbon_large = $total_brown_ribbon_large + $total_ribbon->material_stocks;
                                                                            }
                                                                            if($total_ribbon->heel_height >= 5 && $total_ribbon->heel_height <= 6){
                                                                                $total_brown_ribbon_medium = $total_brown_ribbon_medium + $total_ribbon->material_stocks;
                                                                            }
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                                if($total_ribbon->category == 'HEELS'){
                                                                    if($total_ribbon->name == "BROWN_RIBBON"){
                                                                        $total_brown_ribbon_small = $total_brown_ribbon_small + $total_ribbon->material_stocks;
                                                                    }
                                                                }
                                                                if(!$total_ribbon->products_id){
                                                                    if($total_ribbon->name == 'BROWN_RIBBON'){
                                                                        $total_brown_ribbon_deducted += $total_ribbon->material_stocks;
                                                                    }
                                                                    if($total_ribbon->name == 'WHITE_RIBBON'){
                                                                        $total_white_ribbon_deducted += $total_ribbon->material_stocks;
                                                                    }
                                                                    
                                                                }
                                                            }
                                                        }
                                                        
                                                    }
                                                    // Get the total stocks base on the date as well as the ribbons
                                                    foreach ($getMaterialStocks as $stock) {

                                                        if ($stock->packaging_material_id == $material->id && $stock->date == $date->date) {
                                                            if ($stock->status == 'INCOMING') {
                                                                $incomingStock += $stock->total_stocks;
                                                            } 
                                                            if ($stock->status == 'OUTGOING') {
                                                                if($stock->packaging_material_id == 19){
                                                                    $outgoingStock = $total_white_ribbon_large + $total_white_ribbon_medium + $total_white_ribbon_deducted;
                                                                }
                                                                else if($stock->packaging_material_id == 20){
                                                                    $outgoingStock = $total_brown_ribbon_small + $total_brown_ribbon_medium + $total_brown_ribbon_deducted + $total_brown_ribbon_large;
                                                                }
                                                                else {
                                                                    $outgoingStock += $stock->total_stocks;
                                                                }
                                                            }
                                                        }
                                                    } 
                                                    $incomingStockSum += $incomingStock;
                                                    $outgoingStockSum += $outgoingStock;
                                                @endphp
                                                <td class="bg-emerald-400">{{ $incomingStock }}</td>
                                                <td class="bg-red-400">{{ $outgoingStock }}</td>
                                            @endforeach

                                            <td class="bg-emerald-400">{{ $incomingStockSum }}</td>
                                            <td class="bg-red-400">{{ $outgoingStockSum }}</td>
                                            <td class="bg-blue-400">{{ $remainingStocks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                                
                            </table>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
