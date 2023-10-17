{{-- <table style="color: red;">
    <caption>
        <h1 class="font-bold text-2xl">Summary</h1>
    </caption>
    <thead>
        <tr>
            <th>TEST</th>
        </tr>
        <tr>
            <th  class="bg-gray-500 text-white"># Dates</th>
            @foreach ($dates as $date)
                <th colspan="2" class="bg-orange-500 text-white border">{{ $date->date }}</th>
            @endforeach
            <th colspan="3"  class="bg-gray-500 text-white">Total</th>
        </tr>
        <tr>
            <th class="bg-gray-500 text-white">Names</th>
            @foreach ($dates as $date)
                <th class="bg-emerald-500 text-white">Add</th>
                <th class="bg-red-500 text-white">Rel.</th>
            @endforeach
            <th class="bg-emerald-500 text-white">Add</th>
            <th class="bg-red-500 text-white">Rel.</th>
            <th class="bg-blue-500 text-white">Rem.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materials as $material)
            <tr class="border">
                <td  class="bg-gray-500 text-white">{{ $material->name }}</td>
                @php
                    // DAILY
                    $incomingStockSum = 0;
                    $outgoingStockSum = 0;
                    // TOTAL
                    $totalIncomingStockSum = 0;
                    $totalOutgoingStockSum = 0;

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
                        $a_total_white_ribbon_large = 0;
                        $a_total_white_ribbon_medium = 0;
                        $a_total_brown_ribbon_medium = 0;
                        $a_total_brown_ribbon_small = 0;
                        $total_white_ribbon = 0;
                        $total_brown_ribbon = 0;
                        
                        foreach ($getMaterialStocks as $stock) {
                            if ($stock->packaging_material_id == $material->id && $stock->date == $date->date) {
                                if ($stock->status == 'INCOMING') {
                                    $incomingStock += $stock->total_stocks;
                                } 
                                if ($stock->status == 'OUTGOING') {
                                    // CHEKC IF THE MATERIAL IS == TO 19 || 20
                                    if($stock->packaging_material_id == 19 || $stock->packaging_material_id == 20){
                                        // ITERATE OVER THE DATA:getTotalRibbon TO GET THE TOTAL AMOUNT OF OUTGOING MATERIALS IN 19 || 20
                                        foreach ($getTotalRibbon as $total_ribbon){
                                            // check if the $dates is = to the $total_ribbon->date for accurate computation
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
                                            
                                        // check if the total computation from LOOP is = to the Material id : 19 || 20
                                        if($stock->packaging_material_id == 19){
                                            $outgoingStock = number_format(($total_white_ribbon_large / 20) + ($total_white_ribbon_medium / 15), 2);
                                        }
                                        if($stock->packaging_material_id == 20){
                                            $outgoingStock = number_format(($total_brown_ribbon_small / 15) + ($total_brown_ribbon_medium / 20), 2);
                                        } 
                                    }
                                    else {
                                        $outgoingStock += $stock->total_stocks;
                                    }
                                }
                            }
                        } 
                    @endphp
                    <td class="bg-emerald-800 text-white">{{ $incomingStock }}</td>
                    <td class="bg-red-900 text-white">{{ $outgoingStock }}</td>
                @endforeach

                @foreach ($getMaterialStockss as $stocks)
                    @php
                        $totalIncomingStock = 0;
                        $totalOutgoingStock = 0;
                        if ($stocks->packaging_material_id == $material->id) {
                            if ($stocks->status == 'INCOMING') {
                                $totalIncomingStock += $stocks->total_stocks;
                            } 
                            if ($stocks->status == 'OUTGOING') {
                                // CHEKC IF THE MATERIAL IS == TO 19 || 20
                                if($stocks->packaging_material_id == 19 || $stocks->packaging_material_id == 20){
                                    // ITERATE OVER THE DATA:getTotalRibbon TO GET THE TOTAL AMOUNT OF OUTGOING MATERIALS IN 19 || 20
                                    foreach ($getTotalRibbon as $total_ribbons){
                                        if($total_ribbons->category == 'PAGEANT'){
                                            if($total_ribbons->name == "WHITE_RIBBON"){
                                                if($total_ribbons->size >= 9 && $total_ribbons->size <= 12 || $total_ribbons->size >= 39 && $total_ribbons->size <= 42){
                                                    $a_total_white_ribbon_large += $total_ribbons->material_stocks;
                                                }
                                                else{
                                                    $a_total_white_ribbon_medium += $total_ribbons->material_stocks;
                                                }
                                            }
                                            else{
                                                if($total_ribbons->name == "BROWN_RIBBON"){
                                                    if($total_ribbons->heel_height >= 5 && $total_ribbons->heel_height <= 6){
                                                        $a_total_brown_ribbon_medium += $total_ribbons->material_stocks;
                                                    }
                                                }
                                                
                                            }
                                        }
                                        if($total_ribbons->category == 'HEELS'){
                                            if($total_ribbons->name == "BROWN_RIBBON"){
                                                $a_total_brown_ribbon_small += $total_ribbons->material_stocks;
                                            }
                                        }
                                    }
                                    // check if the total computation from LOOP is = to the Material id : 19 || 20
                                    if($stocks->packaging_material_id == 19){
                                        $totalOutgoingStock = number_format(($a_total_white_ribbon_large / 20) + ($a_total_white_ribbon_medium / 15), 2);
                                    }
                                    if($stocks->packaging_material_id == 20){
                                        $totalOutgoingStock = number_format(($a_total_brown_ribbon_small / 15) + ($a_total_brown_ribbon_medium / 20), 2);
                                    }
                                }    
                                else {
                                    $totalOutgoingStock += $stocks->total_stocks;
                                }
                            }
                            $totalIncomingStockSum += $totalIncomingStock;
                            $totalOutgoingStockSum += $totalOutgoingStock;
                        }
                        
                    @endphp
                    
                @endforeach
                <td class="bg-emerald-500 text-white">{{ $totalIncomingStockSum }}</td>
                <td class="bg-red-500 text-white">{{ $totalOutgoingStockSum }}</td>
                <td class="bg-blue-500 text-white">{{ $totalIncomingStockSum + $totalOutgoingStockSum }}</td>
            </tr>
        @endforeach
    </tbody>
    
    
</table> --}}

<table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400 overflow-x-auto ">
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
            <th  class="bg-gray-500 text-white"># Dates</th>
            @foreach ($dates as $date)
                <th colspan="2" class="bg-orange-500 text-white border">{{ $date->date }}</th>
            @endforeach
            <th colspan="3"  class="bg-gray-500 text-white">Total</th>
        </tr>
        <tr>
            <th class="bg-gray-500 text-white">Names</th>
            @foreach ($dates as $date)
                <th class="bg-emerald-500 text-white">Add</th>
                <th class="bg-red-500 text-white">Rel.</th>
            @endforeach
            <th class="bg-emerald-500 text-white">Add</th>
            <th class="bg-red-500 text-white">Rel.</th>
            <th class="bg-blue-500 text-white">Rem.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materials as $material)
            <tr class="border">
                <td  class="bg-gray-500 text-white">{{ $material->name }}</td>
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
                    <td class="bg-emerald-800 text-white">{{ $incomingStock }}</td>
                    <td class="bg-red-900 text-white">{{ $outgoingStock }}</td>
                @endforeach

                <td class="bg-emerald-500 text-white">{{ $incomingStockSum }}</td>
                <td class="bg-red-500 text-white">{{ $outgoingStockSum }}</td>
                <td class="bg-blue-500 text-white">{{ $incomingStockSum + $outgoingStockSum }}</td>
            </tr>
        @endforeach
    </tbody>
    
    
</table>