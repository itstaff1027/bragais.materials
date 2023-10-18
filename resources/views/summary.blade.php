
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
            <tr style="text-align: center;">
                <td style="text-align: center; font-weight: bold;">{{ $material->name }} : {{ $material->size }}</td>
                @php
                    $incomingStockSum = 0;
                    $outgoingStockSum = 0;
                @endphp
                @foreach ($dates as $date)
                    @php
                        $incomingStock = 0;
                        $outgoingStock = 0;
                        // OVERALL - SET ZERO
                        $total_white_ribbon_large = 0;
                        $total_white_ribbon_medium = 0;
                        $total_brown_ribbon_medium = 0;
                        $total_brown_ribbon_small = 0;
                        $total_white_ribbon = 0;
                        $total_brown_ribbon = 0;

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
                                }
                            }
                            
                        }

                        foreach ($getMaterialStocks as $stock) {
                            if ($stock->packaging_material_id == $material->id && $stock->date == $date->date) {
                                if ($stock->status == 'INCOMING') {
                                    $incomingStock += $stock->total_stocks;
                                } 
                                if ($stock->status == 'OUTGOING') {
                                    if($stock->packaging_material_id == 19){
                                        $outgoingStock = number_format(($total_white_ribbon_large / 20) + ($total_white_ribbon_medium / 15), 2);
                                    }
                                    else if($stock->packaging_material_id == 20){
                                        $outgoingStock = number_format(($total_brown_ribbon_small / 15) + ($total_brown_ribbon_medium / 20), 2);
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
                    <td>{{ $incomingStock }}</td>
                    <td class="bg-red-900 text-white">{{ $outgoingStock }}</td>
                @endforeach

                <td class="bg-emerald-500 text-white">{{ $incomingStockSum }}</td>
                <td class="bg-red-500 text-white">{{ $outgoingStockSum }}</td>
                <td style="color: red; font-weight: bold; text-decoration: underline;">{{ $incomingStockSum + $outgoingStockSum }}</td>
            </tr>
        @endforeach
    </tbody>
    
    
</table>