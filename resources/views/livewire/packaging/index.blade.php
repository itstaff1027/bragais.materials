<div>
    <div class="flex overflow-x-auto">
        {{-- GET THE USED PILON PER PCS IF DECIMAL HIT WHOLE NUMBER MEANS ALREAD USED UP 1 ROLL --}}
        @foreach ($getTotalPilon as $totalPilon)
        @php
            if($totalPilon->size == 'LARGE'){
                $PilonPerRoll = -($totalPilon->released_stocks);
            }
            else if($totalPilon->size == 'MEDIUM'){
                $PilonPerRoll = -($totalPilon->released_stocks);
            }
            else if($totalPilon->size == 'SMALL'){
                $PilonPerRoll = -($totalPilon->released_stocks);
            }
            else{
                if($totalPilon->name == 'LL_PILON_MANDIATOR'){
                    $PilonPerRoll = -($totalPilon->released_stocks);
                }
            }
        @endphp
        <div class="m-1">
            <label class="m-2 font-bold {{ $totalPilon->name == 'LL_PILON_MANDIATOR' || $totalPilon->name == 'LL_PILON_WONDIATOR' ? 'text-xs' : '' }}">{{ $totalPilon->name }} : {{ $totalPilon->size }}</label>
            <input class="m-2 w-max" type="text" value="{{ number_format($PilonPerRoll, 2) }}" disabled />
        </div>
        @endforeach
    </div>

    {{-- <div class="w-1/2 border-2 flex flex-col">
        @foreach ($getTotalRibbon as $total_ribbon)
            <h1>{{ $total_ribbon->model }} {{ $total_ribbon->name }} {{ $total_ribbon->material_stocks }} {{ $total_ribbon->size }} {{ $total_ribbon->heel_height }} {{ $total_ribbon->category }}</h1>
        @endforeach
    </div> --}}

    {{-- {{ $packaging_materials }} --}}

    <div class="flex overflow-x-auto">
        @php
            $total_white_ribbon_large = 0;
            $total_white_ribbon_medium = 0;
            $total_brown_ribbon_medium = 0;
            $total_brown_ribbon_small = 0;
            $total_white_ribbon = 0;
            $total_brown_ribbon = 0;
        @endphp

        {{-- ITERATE over the data to SUM UP all the used ribbons per pcs in per boxes --}}
        @foreach ($getTotalRibbon as $total_ribbon)
            @php
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
            @endphp
        @endforeach

        @php
            $test = 1;
            // SET the value of used ribbons per pcs if the decimal HIT whole number means its one roll
            // $total_white_ribbon_large = $total_white_ribbon_large / 20;
            // $total_white_ribbon_medium = $total_white_ribbon_medium / 15;

            // $total_brown_ribbon_small = $total_brown_ribbon_small / 15;
            // $total_brown_ribbon_medium = $total_brown_ribbon_medium / 20;

            // SET TOTAL USED RIBBON IN TOTAL
            $total_white_ribbon = ($total_white_ribbon_large / 20) + ($total_white_ribbon_medium / 15);
            $total_brown_ribbon = ($total_brown_ribbon_small / 15) + ($total_brown_ribbon_medium / 20);

        @endphp
        <div class="w-full flex flex-col">
            <label class="m-2 font-bold text-xs">W. R. in Used in Large Box</label>
            <input class="m-2 w-max" type="text" value="{{ number_format(($total_white_ribbon_large / 20), 2) }}" disabled />
        </div>
        <div class="w-full flex flex-col">
            <label class="m-2 font-bold text-xs">W. R. in Used in Medium Box</label>
            <input class="m-2 w-max" type="text" value="{{ number_format(($total_white_ribbon_medium / 15), 2) }}" disabled />
        </div>
        <div class="w-full flex flex-col">
            <label class="m-2 font-bold text-xs">B. R. in Used in Medium Box</label>
            <input class="m-2 w-max" type="text" value="{{ number_format(($total_brown_ribbon_medium / 20), 2) }}" disabled />
        </div>
        <div class="w-full flex flex-col">
            <label class="m-2 font-bold text-xs">B. R. in Used in Small Box</label>
            <input class="m-2 w-max" type="text" value="{{ number_format(($total_brown_ribbon_small / 15), 2) }}" disabled />
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

    <div class="w-full justify-center items-center flex">
        @foreach ($incomingRibbonStocks as $total_ribbon_stocks)
        <div class="w-full flex flex-col justify-center items-center">
            <label class="m-2 font-bold">
                {{ 
                    $total_ribbon_stocks->packaging_material_id == 19 ? 
                        'TOTAL STOCKS W.R. - REM. : '.number_format($total_ribbon_stocks->incoming_stocks + $total_white_ribbon, 2) 
                        : 
                        'TOTAL STOCKS B.R. - REM. : '.number_format($total_ribbon_stocks->incoming_stocks + $total_brown_ribbon, 2) 
                }}
            </label>
            <input class="m-2 w-max" type="text" value="{{ $total_ribbon_stocks->incoming_stocks }}" disabled />
        </div>
        @endforeach
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
            <caption>
                <h1 class="italic text-xl font-bold p-2">All Materials For Complete Packagin</h1>
            </caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Size</th>
                    {{-- <th>Beg. Stocks</th> --}}
                    <th>Stocks</th>
                    <th>Released Stocks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packaging_materials as $packaging_material)
                <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200">
                    <td class="p-2">{{ $packaging_material->id }}</td>
                    <td>{{ $packaging_material->name }}</td>
                    <td>{{ $packaging_material->size }}</td>
                    {{-- <td>{{ $packaging_material->beginning_total_stocks }}</td> --}}
                    <td>
                        @if ($packaging_material->name == 'WHITE_RIBBON')
                            {{ number_format($packaging_material->beginning_total_stocks + $total_white_ribbon, 2)  }}
                        @elseif ($packaging_material->name == 'BROWN_RIBBON')
                            {{ number_format($packaging_material->beginning_total_stocks + $total_brown_ribbon, 2)  }}
                        @else
                            {{ $packaging_material->total_stocks }}
                        @endif
                    </td>
                    <td>
                        @if ($packaging_material->name == 'WHITE_RIBBON')
                            {{ number_format($total_white_ribbon, 2)  }}
                        @elseif ($packaging_material->name == 'BROWN_RIBBON')
                            {{ number_format($total_brown_ribbon, 2)  }}
                        @else
                            {{ $packaging_material->released_stocks }}
                        @endif
                    </td>
                    <td>
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
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- <div class="p-3">
        {{ $packaging_materials->links() }}
    </div> --}}

</div>