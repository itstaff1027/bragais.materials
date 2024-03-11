
<table class="table-fixed table-y-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400" lazy>
    <thead>
        <tr>
            <th class="w-36" style="text-align: center; font-weight: bold;"># Dates</th>
            @foreach ($dates as $date)
                <th colspan="2" class="bg-orange-500 border w-28" style="text-align: center; font-weight: bold; background-color: orange">{{ $date->date }}</th>
            @endforeach
            <th colspan="3"  class="bg-gray-500 w-40" style="text-align: center; font-weight: bold;">Total</th>
        </tr>
        <tr>
            <th class="w-36" style="text-align: center; font-weight: bold;">Names</th>
            @foreach ($dates as $date)
                <th class="bg-emerald-500" style="text-align: center; font-weight: bold; background-color: green text-decoration: underline;">+</th>
                <th class="bg-red-500" style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">-</th>
            @endforeach
            <th class="bg-emerald-500" style="text-align: center; font-weight: bold; color: green; text-decoration: underline;">+</th>
            <th class="bg-red-500" style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">-</th>
            <th class="bg-blue-500" style="text-align: center; font-weight: bold; color: blue; text-decoration: underline;">+-</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            
            @php
            // dd($product);
                $totalIncoming = 0;
                $totalOutgoing = 0;
            @endphp
            <tr class="border-2">
                <td class="border-2" style="text-align: center; font-weight: bold;">{{ $product->product_sku }}</td>

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
                        <td class="border-2" style="text-align: center; font-weight: bold; ">{{ $incoming }}</td>
                    @else
                        <td class="border-2" style="text-align: center; font-weight: bold;  color:red;"></td>
                    @endif
                    @if($outgoing)
                        <td class="border-2" style="text-align: center; font-weight: bold;">{{ $outgoing ? $outgoing : '' }}</td>
                    @else
                        <td class="border-2" style="text-align: center; font-weight: bold;"></td>
                    @endif
                @endforeach
                <td class="border-2">{{ $totalIncoming }}</td>
                <td class="border-2">{{ $totalOutgoing }}</td>
                <td>{{ $product->total_stocks }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
