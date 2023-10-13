<div>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Packaging Summary') }}
                </h2>
                {{-- <a href="{{ route('packaging-per-day') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Per Day') }}
                </a>
                <a href="{{ route('summary') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Summary') }}
                </a>
                <a href="{{ route('material-logs') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{ __('Material Logs') }}
                </a> --}}
            </div>
            
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400 overflow-auto">
                            <caption>
                                <h1 class="font-bold text-2xl">Summary</h1>
                            </caption>
                            <thead>
                                <tr>
                                    <th># Dates</th>
                                    @foreach ($dates as $date)
                                        <th colspan="2">{{ $date->date }}</th>
                                    @endforeach
                                    <th colspan="3">Total</th>
                                </tr>
                                <tr>
                                    <th>Names</th>
                                    @foreach ($dates as $date)
                                        <th>A.</th>
                                        <th>Stk.</th>
                                    @endforeach
                                    <th>A.</th>
                                    <th>Stk.</th>
                                    <th>Rem.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td>{{ $material->name }}</td>
                                        @php
                                            $incomingStockSum = 0;
                                            $outgoingStockSum = 0;
                                        @endphp
                                        @foreach ($dates as $date)
                                            @php
                                                $incomingStock = 0;
                                                $outgoingStock = 0;
                                                foreach ($getMaterialStocks as $stock) {
                                                    if ($stock->packaging_material_id == $material->id && $stock->date == $date->date) {
                                                        if ($stock->status == 'INCOMING') {
                                                            $incomingStock += $stock->total_stocks;
                                                        } elseif ($stock->status == 'OUTGOING') {
                                                            $outgoingStock += $stock->total_stocks;
                                                        }
                                                    }
                                                }
                                                $incomingStockSum += $incomingStock;
                                                $outgoingStockSum += $outgoingStock;
                                            @endphp
                                            <td>{{ $incomingStock }}</td>
                                            <td>{{ $outgoingStock }}</td>
                                        @endforeach
                                        <td>{{ $incomingStockSum }}</td>
                                        <td>{{ $outgoingStockSum }}</td>
                                        <td>{{ $incomingStockSum + $outgoingStockSum }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
