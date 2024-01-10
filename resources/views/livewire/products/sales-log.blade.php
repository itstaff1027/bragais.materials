<div>
    <div class="flex justify-between">
        <form class="flex flex-col" wire:submit.prevent='getSalesLogs'>
            <input type=text wire:model='date_today' placeholder="DATE FORMAT: 1111-11-11" />
            <button type="submit"> SEARCH </button>
        </form>
        <form class="flex flex-col" wire:submit.prevent='getOrder'>
            <input type=text wire:model='get_order_number' placeholder="Order No - 1234" />
            <button type="submit"> SEARCH </button>
        </form>
    </div>
    
    
    <div class="overflow-x-auto">
        <table class="table-fixed w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
            <caption>
                <h1 class="italic text-xl font-bold p-2">Sales Logs</h1>
            </caption>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Order Type</th>
                    <th>Sale</th>
                    <th>Order Lists</th>
                    <th>Package</th>
                    <th>Courier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200" wire:key:='{{ $order['OrderNo'] }}'>
                    <td class="p-2">{{ $order['OrderNo'] }}</td>
                    <td>{{ $order['OrderType'] }}</td>
                    <td>{{ $order['Sale'] }}</td>
                    <td>
                        @php
                            $lists = explode(',', $order['OrderList'])
                        @endphp
                        @foreach ($lists as $list)
                            <div>{{ $list }}</div>
                        @endforeach
                    </td>
                    <td>{{ $order['Packaging'] }}</td>
                    <td>{{ $order['Courier'] }}</td>
                    <td>
                        <form wire:submit.prevent="addToCompletePackaging('{{ $order['OrderNo'] }}', '{{ $order['OrderList'] }}', '{{ $order['Packaging'] }}', '{{ $order['Sale'] }}')" 
                        wire:confirm="Are you sure you want to add this to complete packaging?"
                        >
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                    class="fill-green-400">
                                    <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    </style>
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                </svg>
                            </button>
                            <div wire:loading> 
                                Saving post...
                            </div>
                        </form>
                        <form wire:submit.prevent="addDeliveredOrders('{{ $order['OrderNo'] }}', '{{ $order['OrderList'] }}', '{{ $order['ClosedSaleDate'] }}', '{{ $order['Sale'] }}', '{{ $order['Courier'] }}')"
                        wire:confirm="Has this order already been delivered?"
                        >
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M640 0V400c0 61.9-50.1 112-112 112c-61 0-110.5-48.7-112-109.3L48.4 502.9c-17.1 4.6-34.6-5.4-39.3-22.5s5.4-34.6 22.5-39.3L352 353.8V64c0-35.3 28.7-64 64-64H640zM576 400a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM23.1 207.7c-4.6-17.1 5.6-34.6 22.6-39.2l46.4-12.4 20.7 77.3c2.3 8.5 11.1 13.6 19.6 11.3l30.9-8.3c8.5-2.3 13.6-11.1 11.3-19.6l-20.7-77.3 46.4-12.4c17.1-4.6 34.6 5.6 39.2 22.6l41.4 154.5c4.6 17.1-5.6 34.6-22.6 39.2L103.7 384.9c-17.1 4.6-34.6-5.6-39.2-22.6L23.1 207.7z"/></svg>
                            </button>
                            <div wire:loading> 
                                Saving post...
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    
        </table>
    </div>
</div>