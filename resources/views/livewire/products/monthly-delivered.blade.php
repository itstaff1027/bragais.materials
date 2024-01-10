<div x-data="{ open: false }">
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
        <button type="button" wire:click="filterBySoldFrom('STORE')">STORE</button>
        <button type="button" wire:click="filterBySoldFrom('ONLINE')">ONLINE</button>
        {{-- <input type="radio" value="STORE" wire:click="filterBySoldFrom('STORE')" />
        <input type="radio" value="ONLINE" wire:click="filterBySoldFrom('ONLINE')" /> --}}
    </div>
    @php
        $size_us = ['5', '6', '7', '8', '9', '10', '11', '12'];
        $size_euro = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
    @endphp
    <table class="table-auto w-full text-center divide-y-2 border-2 ">
        <caption>
            <h1 class="font-bold text-2xl">Summary</h1>
        </caption>
        <thead>
            <tr>
                <th>DATE : {{ $today }}</th>
                <th>Total Quantity : {{ $totalQuantity }}</th>
            </tr>
            <tr class=" border-2 ">
                <th>Closed Sale Date</th>
                <th>Released Date</th>
                <th>Order Number</th>
                <th>Courier</th>
                <th>Design</th>
                <th>Color</th>
                <th colspan="8" class="border-2">Size</th>
                <th>Heel Height</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                @foreach ($size_us as $sizes)
                    <th class=" border-2 ">{{ $sizes }}</th>
                @endforeach
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quantitiesUS as $key => $sizes)
                @php
                    list($model, $color, $heelHeight, $closedSaleDate, $orderNumber, $created_at, $courier) = explode(',', $key);
                    $totalQuantityUS = 0;
                @endphp
                <tr>
                    <td>{{ $closedSaleDate }}</td>
                    <td>{{ $created_at }}</td>
                    <td>{{ $orderNumber }}</td>
                    <td>{{ $courier }}</td>
                    <td>{{ $model }}</td>
                    <td>{{ $color }}</td>
                    @foreach ($size_us as $size)
                        <td class=" border-2 ">
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
                    <td>{{ $heelHeight }}</td>
                    <td>{{ $totalQuantityUS }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <table class="table-auto w-full text-center divide-y-2 border-2 ">
        <thead>
            <tr class=" border-2 ">
                <th>Closed Sale Date</th>
                <th>Released Date</th>
                <th>Order Number</th>
                <th>Courier</th>
                <th>Design</th>
                <th>Color</th>
                <th colspan="11" class="border-2">Size</th>
                <th>Heel Height</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                @foreach ($size_euro as $sizes)
                    <th class=" border-2 ">{{ $sizes }}</th>
                @endforeach
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quantitiesEURO as $key => $sizes)
                @php
                    list($model, $color, $heelHeight, $closedSaleDate, $orderNumber, $created_at, $courier) = explode(',', $key);
                    $totalQuantityEURO = 0;
                @endphp
                <tr>
                    <td>{{ $closedSaleDate }}</td>
                    <td>{{ $created_at }}</td>
                    <td>{{ $orderNumber }}</td>
                    <td>{{ $courier }}</td>
                    <td>{{ $model }}</td>
                    <td>{{ $color }}</td>
                    @foreach ($size_euro as $size)
                        <td class=" border-2 ">
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
                    <td>{{ $heelHeight }}</td>
                    <td>{{ $totalQuantityEURO }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>