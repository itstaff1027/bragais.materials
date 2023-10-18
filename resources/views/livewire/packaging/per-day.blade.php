<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Packaging - Per Day') }}
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" x-data="{ open: false }">
                        <div class="flex w-full p-2 mb-4">
                            <a href="{{ route('generate-pdf') }}" class="border-2 p-2 mr-2 rounded-md border-blue-400">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                </button>
                            </a>
                            <input type="text" class="w-full rounded-l-md border-2 border-blue-400 border-r-0"  wire:model.live.debounce.500ms='filter_date' placeholder="Search by DATE : FORMAT [y-m-d]" />

                            <button class="rounded-r-md border-2 border-blue-400 border-l-1 p-2" @click="open = ! open">Filter</button>
                            
                        </div>

                        <div class="w-full flex flex-col items-end justify-end" x-show="open" x-transition.duration.500ms>
                            <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='filter_date_range_first' placeholder="DATE-FIRST : FORMAT [y-m-d]" />
                            <input type="text" class="w-1/4 rounded-l-md border-2 border-blue-400 m-2"  wire:model.live.debounce.500ms='filter_date_range_second' placeholder="DATE-SECOND : FORMAT [y-m-d]" />
                        </div>
                            <div class="flex overflow-x-auto pt-4">
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
                        
                        
                        
                            <div class="flex overflow-x-auto">
                                @php
                                    // OVERALL
                                    $total_white_ribbon_large = 0;
                                    $total_white_ribbon_medium = 0;
                                    $total_brown_ribbon_medium = 0;
                                    $total_brown_ribbon_small = 0;
                                    $total_white_ribbon = 0;
                                    $total_brown_ribbon = 0;
                                    // TODAY
                                    $today_total_white_ribbon_large = 0;
                                    $today_total_white_ribbon_medium = 0;
                                    $today_total_brown_ribbon_medium = 0;
                                    $today_total_brown_ribbon_small = 0;
                                    $today_total_white_ribbon = 0;
                                    $today_total_brown_ribbon = 0;
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
                                        {{-- GET TOTAL RIBBON BASE ON THE DAY --}}
                                @foreach ($getTotalRibbonToday as $today_total_ribbon)
                                    @php
                                        if($today_total_ribbon->category == 'PAGEANT'){
                                            if($today_total_ribbon->name == "WHITE_RIBBON"){
                                                if($today_total_ribbon->size >= 9 && $today_total_ribbon->size <= 12 || $today_total_ribbon->size >= 39 && $today_total_ribbon->size <= 42){
                                                    $today_total_white_ribbon_large = $today_total_white_ribbon_large + $today_total_ribbon->material_stocks;
                                                }
                                                else{
                                                    $today_total_white_ribbon_medium = $today_total_white_ribbon_medium + $today_total_ribbon->material_stocks;
                                                }
                                            }
                                            else{
                                                if($today_total_ribbon->name == "BROWN_RIBBON"){
                                                    if($today_total_ribbon->heel_height >= 5 && $today_total_ribbon->heel_height <= 6){
                                                        $today_total_brown_ribbon_medium = $today_total_brown_ribbon_medium + $today_total_ribbon->material_stocks;
                                                    }
                                                }
                                                
                                            }
                                        }
                                        if($today_total_ribbon->category == 'HEELS'){
                                            if($today_total_ribbon->name == "BROWN_RIBBON"){
                                                $today_total_brown_ribbon_small = $today_total_brown_ribbon_small + $today_total_ribbon->material_stocks;
                                            }
                                        }
                                    @endphp
                                @endforeach

                                @php
                                    $test = 1;

                                    // SET TOTAL USED RIBBON IN TOTAL
                                    $total_white_ribbon = ($total_white_ribbon_large / 20) + ($total_white_ribbon_medium / 15);
                                    $total_brown_ribbon = ($total_brown_ribbon_small / 15) + ($total_brown_ribbon_medium / 20);

                                    // SET TOTAL USED RIBBON IN TODAY_TOTAL
                                    $today_total_white_ribbon = ($today_total_white_ribbon_large / 20) + ($today_total_white_ribbon_medium / 15);
                                    $today_total_brown_ribbon = ($today_total_brown_ribbon_small / 15) + ($today_total_brown_ribbon_medium / 20);

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
                                                'REM. STOCKS W.R. - '.number_format($total_ribbon_stocks->incoming_stocks + $total_white_ribbon, 2)
                                                : 
                                                'REM. STOCKS B.R. - '.number_format($total_ribbon_stocks->incoming_stocks + $total_brown_ribbon, 2) 
                                        }}
                                    </label>
                                    {{-- <input class="m-2 w-max" type="text" value="{{ $total_ribbon_stocks->incoming_stocks }}" disabled /> --}}
                                </div>
                                @endforeach
                                
                            </div>
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
                                    <caption>
                                        <h1 class="italic text-xl font-bold p-2">All Materials Released Per Day</h1>
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Added Stock</th>
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
                                            <td>{{ $packaging_material->added_total_stocks }}</td>
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
                                                    {{ number_format($today_total_white_ribbon, 2) }}
                                                @elseif ($packaging_material->name == 'BROWN_RIBBON')
                                                    {{ number_format($today_total_brown_ribbon, 2) }}
                                                @else
                                                    {{ $packaging_material->released_stocks }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                        
                                </table>
                            </div>
                        
                            <div class="p-3">
                                {{ $packaging_materials->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
</div>