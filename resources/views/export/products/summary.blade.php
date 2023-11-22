<table class="table-auto w-full text-center divide-y-2 border-2 ">
    @php
        $size_us = ['5', '6', '7', '8', '9', '10', '11', '12'];
        $size_euro = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
    @endphp
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
            <th style="text-align: center; font-weight: bold;">DATE : {{ $today }}</th>
        </tr>
        <tr class=" border-2 ">
            <th style="text-align: center; font-weight: bold;">Closed Sale Date</th>
            <th style="text-align: center; font-weight: bold;">Released Date</th>
            <th style="text-align: center; font-weight: bold;">Design</th>
            <th style="text-align: center; font-weight: bold;">Color</th>
            <th colspan="8" style="text-align: center; font-weight: bold;">Size</th> 
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: center; font-weight: bold;">Heel Height</th>
            <th style="text-align: center; font-weight: bold;">Quantity</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            @foreach ($size_us as $sizes)
                <th  style="text-align: center; font-weight: bold; background-color: yellow;">{{ $sizes }}</th>
            @endforeach
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quantitiesUS as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $closedSaleDate) = explode(',', $key);
                $totalQuantityUS = 0;
            @endphp
            <tr>
                <td style="text-align: center; font-weight: bold;">{{ $closedSaleDate }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $today }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $model }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $color }}</td>
                @foreach ($size_us as $size)
                    <td class=" border-2 " style="text-align: center; font-weight: bold;">
                        @if(isset($sizes[$size]))
                            {{ $sizes[$size] }}
                            @php
                                $totalQuantityUS += $sizes[$size];
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                @endforeach
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: center; font-weight: bold;">{{ $heelHeight }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $totalQuantityUS }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<br><br>
<table class="table-auto w-full text-center divide-y-2 border-2 ">
    <thead>
        <tr class=" border-2 ">
            <th style="text-align: center; font-weight: bold;">Closed Sale Date</th>
            <th style="text-align: center; font-weight: bold;">Released Date</th>
            <th style="text-align: center; font-weight: bold;">Design</th>
            <th style="text-align: center; font-weight: bold;">Color</th>
            <th colspan="11" style="text-align: center; font-weight: bold;">Size</th>
            <th style="text-align: center; font-weight: bold;">Heel Height</th>
            <th style="text-align: center; font-weight: bold;">Quantity</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            @foreach ($size_euro as $sizes)
                <th  style="text-align: center; font-weight: bold; background-color: yellow;">{{ $sizes }}</th>
            @endforeach
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quantitiesEURO as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $closedSaleDate) = explode(',', $key);
                $totalQuantityEURO = 0;
            @endphp
            <tr>
                <td style="text-align: center; font-weight: bold;">{{ $closedSaleDate }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $today }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $model }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $color }}</td>
                @foreach ($size_euro as $size)
                    <td class=" border-2 " style="text-align: center; font-weight: bold;">
                        @if(isset($sizes[$size]))
                            {{ $sizes[$size] }}
                            @php
                                $totalQuantityEURO += $sizes[$size];
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                @endforeach
                <td style="text-align: center; font-weight: bold;">{{ $heelHeight }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $totalQuantityEURO }}</td>
            </tr>
        @endforeach
    </tbody>
</table>