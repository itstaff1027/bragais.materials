<table class="tables">
    <caption>
        <h1 class="font-bold text-2xl">Summary</h1>
    </caption>
    <thead>
        <tr>
            <th colspan="15">SHOECIETY INC</th>
        </tr>
        <tr>
            <th colspan="15">JOJO BRAGAIS</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold;"># Dates</th>
            @foreach ($dates as $date)
                <th colspan="2" style="background-color: orange; text-align: center; font-weight: bold;">{{ $date->date }}</th>
            @endforeach
            <th colspan="3"  style="background-color: gray; text-align: center; font-weight: bold;">Total</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold;">Names</th>
            @foreach ($dates as $date)
                <th style="background-color: green; font-weight: bold;">Add</th>
                <th style="background-color: red; font-weight: bold;">Rel.</th>
            @endforeach
            <th style="background-color: green; font-weight: bold;">Add</th>
            <th style="background-color: red; font-weight: bold;">Rel.</th>
            <th style="background-color: yellow; font-weight: bold;">Rem.</th>
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
                <td class="bg-blue-400" style="color: red; font-weight: bold; text-decoration: underline;">{{ $remainingStocks }}</td>
            </tr>
        @endforeach
    </tbody>
</table>