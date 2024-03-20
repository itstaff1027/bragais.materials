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

    {{-- <div class="w-full flex flex-col items-end justify-end" x-show="open" x-transition.duration.500ms>
        <button type="button" wire:click="filterBySoldFrom('STORE')">STORE</button>
        <button type="button" wire:click="filterBySoldFrom('ONLINE')">ONLINE</button>
    </div> --}}
    <div class="w-full">
        <table class="overflow-y table-auto w-full text-center divide-y-2 border-2 ">
            <caption>
                <h1 class="font-bold text-2xl">Summary</h1>
            </caption>
            <thead>
                <tr class=" border-2 ">
                    <th class="w-28">Order Number</th>
                    <th class="w-28">Customer </th>
                    <th class="w-28">Model</th>
                    <th class="w-28">Color</th>
                    <th class="w-28">Size</th>
                    <th class="w-28">Heel Height</th>
                    <th class="w-28">Heel Type</th>
                    <th class="w-28">Round</th>
                    <th class="w-28">Packaging Type</th>
                    <th class="w-28">Sold Date</th>
                    <th class="w-28">Remarks</th>
                    <th class="w-28">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($MTOs as $MTO)
                    <tr>
                        <td>{{ $MTO->order_number }}</td>
                        <td>{{ $MTO->customer_details }}</td>
                        <td>{{ $MTO->model }}</td>
                        <td>{{ $MTO->color }}</td>
                        <td>{{ $MTO->size }}</td>
                        <td>{{ $MTO->heel_height }}</td>
                        <td>{{ $MTO->heel_type }}</td>
                        <td>{{ $MTO->round }}</td>
                        <td>{{ $MTO->packaging_type }}</td>
                        <td>{{ $MTO->sold_date }}</td>
                        <td>{{ $MTO->remarks }}</td>
                        <td>{{ $MTO->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    <br><br>
</div>