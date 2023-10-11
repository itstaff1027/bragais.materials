<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body>
    <div>
        <div class="flex overflow-x-auto">
            {{-- GET THE USED PILON PER PCS IF DECIMAL HIT WHOLE NUMBER MEANS ALREAD USED UP 1 ROLL --}}
            @foreach ($getTotalPilon as $totalPilon)
            @php
                if($totalPilon->size == 'LARGE'){
                    $PilonPerRoll = -($totalPilon->released_stocks) / 180;
                }
                else if($totalPilon->size == 'MEDIUM'){
                    $PilonPerRoll = -($totalPilon->released_stocks) / 200;
                }
                else if($totalPilon->size == 'SMALL'){
                    $PilonPerRoll = -($totalPilon->released_stocks) / 210;
                }
                else{
                    if($totalPilon->name == 'LL_PILON_MANDIATOR'){
                        $PilonPerRoll = -($totalPilon->released_stocks) / 210;
                    }
                    if($totalPilon->name == 'LL_PILON_WONDIATOR'){
                        $PilonPerRoll = -($totalPilon->released_stocks) / 200;
                    }
                }
            @endphp
            <div class="m-1">
                <label class="m-2 font-bold {{ $totalPilon->name == 'LL_PILON_MANDIATOR' || $totalPilon->name == 'LL_PILON_WONDIATOR' ? 'text-xs' : '' }}">{{ $totalPilon->name }} : {{ $totalPilon->size }}</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($PilonPerRoll, 2) }}" disabled />
            </div>
            @endforeach
        </div>
    
    
    
        <div class="flex overflow-x-auto">
            @php
                $total_white_ribbon_large_today = 0;
                $total_white_ribbon_medium_today = 0;
                $total_brown_ribbon_medium_today = 0;
                $total_brown_ribbon_small_today = 0;
                $total_white_ribbon = 0;
                $total_brown_ribbon = 0;
            @endphp
    
            {{-- ITERATE over the data to SUM UP all the used ribbons per pcs in per boxes --}}
            @foreach ($getTotalRibbonToday as $total_ribbon_today)
                @php
                    if($total_ribbon_today->category == 'PAGEANT'){
                        if($total_ribbon_today->name == "WHITE_RIBBON"){
                            if($total_ribbon_today->size >= 8 && $total_ribbon_today->size <= 12){
                                $total_white_ribbon_large_today =+ $total_ribbon_today->material_stocks;
                            }
                            else{
                                $total_white_ribbon_medium_today =+ $total_ribbon_today->material_stocks;
                            }
                        }
                        else{
                            $total_brown_ribbon_medium_today =+ $total_ribbon_today->material_stocks;
                        }
                    }
                    if($total_ribbon_today->category == 'HEELS'){
                        if($total_ribbon_today->name == "BROWN_RIBBON"){
                            $total_brown_ribbon_small_today =+ $total_ribbon_today->material_stocks;
                        }
                    }
                @endphp
            @endforeach
    
            @php
                $test = 1;
                // SET the value of used ribbons per pcs if the decimal HIT whole number means its one roll
                $total_white_ribbon_large_today = $total_white_ribbon_large_today / 20;
                $total_white_ribbon_medium_today = $total_white_ribbon_medium_today / 15;
    
                $total_brown_ribbon_small_today = $total_brown_ribbon_small_today / 15;
                $total_brown_ribbon_medium_today = $total_brown_ribbon_medium_today / 20;
    
                // SET TOTAL USED RIBBON IN TOTAL
                $total_white_ribbon = $total_white_ribbon_large_today + $total_white_ribbon_medium_today;
                $total_brown_ribbon = $total_brown_ribbon_small_today + $total_brown_ribbon_medium_today;
    
            @endphp
    
            <div class="w-full flex flex-col">
                <label class="m-2 font-bold text-xs">W. R. Used in Large Box</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_white_ribbon_large_today, 2) }}" disabled />
            </div>
            <div class="w-full flex flex-col">
                <label class="m-2 font-bold text-xs">W. R. Used in Medium Box</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_white_ribbon_medium_today, 2) }}" disabled />
            </div>
            <div class="w-full flex flex-col">
                <label class="m-2 font-bold text-xs">B. R. Used in Medium Box</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_brown_ribbon_medium_today, 2) }}" disabled />
            </div>
            <div class="w-full flex flex-col">
                <label class="m-2 font-bold text-xs">B. R. Used in Small Box</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_brown_ribbon_small_today, 2) }}" disabled />
            </div>
        </div>
    
        <div class="w-full justify-center items-center flex">
            <div class="w-full flex flex-col justify-center items-center">
                <label class="m-2 font-bold">Total White Ribbon Used</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_white_ribbon, 2) }}" disabled />
            </div>
            <div class="w-full flex flex-col justify-center items-center">
                <label class="m-2 font-bold">Total Brown Ribbon Used</label>
                <input class="m-2 w-max" type="text" value="{{ number_format($total_brown_ribbon, 2) }}" disabled />
            </div>
        </div>
    
        @php
            $A_total_white_ribbon_large = 0;
            $A_total_white_ribbon_medium = 0;
            $A_total_brown_ribbon_medium = 0;
            $A_total_brown_ribbon_small = 0;
            $A_total_white_ribbon = 0;
            $A_total_brown_ribbon = 0;
        @endphp
    
        {{-- ITERATE over the data to SUM UP all the used ribbons per pcs in per boxes --}}
        @foreach ($getTotalRibbon as $total_ribbon)
        @php
            if($total_ribbon->category == 'PAGEANT'){
                if($total_ribbon->name == "WHITE_RIBBON"){
                    if($total_ribbon->size >= 8 && $total_ribbon->size <= 12){
                        $A_total_white_ribbon_large =+ $total_ribbon->material_stocks;
                    }
                    else{
                        $A_total_white_ribbon_medium =+ $total_ribbon->material_stocks;
                    }
                }
                else{
                    $A_total_brown_ribbon_medium =+ $total_ribbon->material_stocks;
                }
            }
            if($total_ribbon->category == 'HEELS'){
                if($total_ribbon->name == "BROWN_RIBBON"){
                    $A_total_brown_ribbon_small =+ $total_ribbon->material_stocks;
                }
            }
        @endphp
    @endforeach
    
    @php
        $test = 1;
        // SET the value of used ribbons per pcs if the decimal HIT whole number means its one roll
        $A_total_white_ribbon_large = $A_total_white_ribbon_large / 20;
        $A_total_white_ribbon_medium = $A_total_white_ribbon_medium / 15;
    
        $A_total_brown_ribbon_small = $A_total_brown_ribbon_small / 15;
        $A_total_brown_ribbon_medium = $A_total_brown_ribbon_medium / 20;
    
        // SET TOTAL USED RIBBON IN TOTAL
        $A_total_white_ribbon = $A_total_white_ribbon_large + $A_total_white_ribbon_medium;
        $A_total_brown_ribbon = $A_total_brown_ribbon_small + $A_total_brown_ribbon_medium;
    
    @endphp
    
        <div class="w-full justify-center items-center flex">
            @foreach ($incomingRibbonStocks as $total_ribbon_stocks)
            <div class="w-full flex flex-col justify-center items-center">
                <label class="m-2 font-bold">
                    {{ 
                        $total_ribbon_stocks->packaging_material_id == 19 ? 
                            'TOTAL STOCKS W.R. - '.number_format($total_ribbon_stocks->incoming_stocks + $total_white_ribbon + $A_total_white_ribbon, 2)
                            : 
                            'TOTAL STOCKS B.R. - '.number_format($total_ribbon_stocks->incoming_stocks + $total_brown_ribbon + $A_total_brown_ribbon, 2) 
                    }}
                </label>
                {{-- <input class="m-2 w-max" type="text" value="{{ $total_ribbon_stocks->incoming_stocks }}" disabled /> --}}
            </div>
            @endforeach
        </div>
    
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
                <caption>
                    <h1 class="italic text-xl font-bold p-2">All Materials Released Per Day
                        {{-- <a href="{{ route('add-new-model') }}">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                    class="fill-green-400">
                                    <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    </style>
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                </svg>
                            </button>
                        </a> --}}
                    </h1>
                    {{-- <div class="m-2" x-data="{ open: false }">
                        <input class="border-2 border-violet-700 rounded-l-full w-1/2 p-2 m-0"
                            wire:model.live.debounce.500ms='packaging_material_sku_search'
                            placeholder="Search Stock [packaging_material SKU]" />
                        <button class="border-2 border-violet-700 rounded-r-full p-2 m-0"
                            @click="open = ! open">Filter</button>
    
                        <div class="m-2" x-show="open" x-transition.duration.500ms>
                            <input class="border-2 border-violet-700 rounded-full w-1/4 m-2"
                                wire:model.live.debounce.500ms='model_search' placeholder="Model" />
                            <input class="border-2 border-violet-700 rounded-full w-1/4 m-2"
                                wire:model.live.debounce.500ms='color_search' placeholder="Color" />
                            <input class="border-2 border-violet-700 rounded-full w-1/4 m-2"
                                wire:model.live.debounce.500ms='size_search' placeholder="Size" />
                            <input class="border-2 border-violet-700 rounded-full w-1/4 m-2"
                                wire:model.live.debounce.500ms='heel_search' placeholder="Heel Height" />
                            <input class="border-2 border-violet-700 rounded-full w-1/4 m-2"
                                wire:model.live.debounce.500ms='category_search' placeholder="Category" />
                        </div>
    
                    </div> --}}
                </caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Stocks</th>
                        <th>Released Stocks</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packaging_materials as $packaging_material)
                    <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200">
                        <td class="p-2">{{ $packaging_material->id }}</td>
                        <td>{{ $packaging_material->name }}</td>
                        <td>{{ $packaging_material->size }}</td>
                        <td>{{ $packaging_material->total_stocks }}</td>
                        <td>{{ -($packaging_material->released_stocks) }}</td>
                        {{-- <td>
                            <a href="{{ route('add-packaging-materials', ['id' => $packaging_material->id]) }}">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                        class="fill-green-400">
                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        </style>
                                        <path
                                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="{{ route('deduct-packaging-materials', ['id' => $packaging_material->id]) }}">
                                <button class="text-red-600">
                                    -
                                </button>
                            </a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
    
            </table>
        </div>
    
        <div class="p-3">
            {{ $packaging_materials->links() }}
        </div>
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>