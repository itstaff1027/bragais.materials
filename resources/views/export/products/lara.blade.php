<table class="table-auto w-full text-center divide-y-2 border-2 ">
    @php
        $size_us = ['5', '6', '7', '8', '9', '10', '11', '12'];
        $size_euro = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
    @endphp
    <caption>
        <h1 class="font-bold text-2xl">Summary - ONLINE</h1>
    </caption>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold;">DATE : {{ $today }} - ONLINE</th>
        </tr>
        <tr class=" border-2 ">
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
        @php
            $totalQuantityOnlineUS = 0
        @endphp
        @foreach ($quantitiesUS as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $order_from) = explode(',', $key);
                $totalQuantityUS = 0;
            @endphp
            @if ($order_from == 'ONLINE')
                @php
                    $totalQuantityOnlineUS++;
                @endphp
                <tr>
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
            @endif

        @endforeach
        <tr>
            <td style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">Total Quantity : {{ $totalQuantityOnlineUS }}</td>
        </tr>
    </tbody>
</table>
<br><br>
<table class="table-auto w-full text-center divide-y-2 border-2 ">
    <thead>
        <tr class=" border-2 ">

            <th style="text-align: center; font-weight: bold;">Design</th>
            <th style="text-align: center; font-weight: bold;">Color</th>
            <th colspan="11" style="text-align: center; font-weight: bold;">Size</th>
            <th style="text-align: center; font-weight: bold;">Heel Height</th>
            <th style="text-align: center; font-weight: bold;">Quantity</th>
        </tr>
        <tr>
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
        @php
        $totalQuantityOnlineEURO = 0
    @endphp
        @foreach ($quantitiesEURO as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $order_from) = explode(',', $key);
                $totalQuantityEURO = 0;
            @endphp
            @if ($order_from == 'ONLINE')
            @php
            $totalQuantityOnlineEURO++;
        @endphp
                <tr>
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
            @endif
            
        @endforeach
        <tr>
            <td style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">Total Quantity : {{ $totalQuantityOnlineEURO }}</td>
        </tr>
    </tbody>
</table>

<br><br>

<table class="table-auto w-full text-center divide-y-2 border-2 ">
    @php
        $size_us = ['5', '6', '7', '8', '9', '10', '11', '12'];
        $size_euro = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
    @endphp
    <caption>
        <h1 class="font-bold text-2xl">Summary - STORE</h1>
    </caption>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold;">DATE : {{ $today }} - STORE</th>
        </tr>
        <tr class=" border-2 ">
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
        @php
        $totalQuantityStoreUS = 0
    @endphp
        @foreach ($quantitiesUS as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $order_from) = explode(',', $key);
                $totalQuantityUS = 0;
            @endphp
            @if ($order_from == 'STORE')
            @php
            $totalQuantityStoreUS++;
        @endphp
                <tr>
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
            @endif
            
        @endforeach
        <tr>
            <td style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">Total Quantity : {{ $totalQuantityStoreUS }}</td>
        </tr>
    </tbody>
</table>
<br><br>
<table class="table-auto w-full text-center divide-y-2 border-2 ">
    <thead>
        <tr class=" border-2 ">

            <th style="text-align: center; font-weight: bold;">Design</th>
            <th style="text-align: center; font-weight: bold;">Color</th>
            <th colspan="11" style="text-align: center; font-weight: bold;">Size</th>
            <th style="text-align: center; font-weight: bold;">Heel Height</th>
            <th style="text-align: center; font-weight: bold;">Quantity</th>
        </tr>
        <tr>
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
        @php
        $totalQuantityStoreEURO = 0
    @endphp
        @foreach ($quantitiesEURO as $key => $sizes)
            @php
                list($model, $color, $heelHeight, $order_from) = explode(',', $key);
                $totalQuantityEURO = 0;
            @endphp
            @if ($order_from == 'STORE')
            @php
            $totalQuantityStoreEURO++;
        @endphp
                <tr>
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
            @endif
            
        @endforeach
        <tr>
            <td style="text-align: center; font-weight: bold; color: red; text-decoration: underline;">Total Quantity : {{ $totalQuantityStoreEURO }}</td>
        </tr>
    </tbody>
</table>