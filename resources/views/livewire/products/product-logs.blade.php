<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Logs') }}
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="p-3">
                            {{ $products->links() }}
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
                                <caption>
                                    <h1 class="italic text-xl font-bold p-2">Product Logs</h1>
                                </caption>
                                <thead>
                                    <tr>
                                        <th>Barcode ID</th>
                                        <th>Order Number</th>
                                        <th>Stocks</th>
                                        <th>Status</th>
                                        <th>Model</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Heel Height</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200">
                                        <td class="p-2">{{ $product->barcode_id }}</td>
                                        <td>{{ $product->order_number }}</td>
                                        <td>{{ $product->stocks }}</td>
                                        <td><p class="{{ $product->status == 'INCOMING' ? 'text-emerald-400' : 'text-red-500' }}">{{ $product->status }}</p></td>
                                        <td>{{ $product->model }}</td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>{{ $product->heel_height }}</td>
                                        {{-- <td>
                                            <a href="{{ route('add-packaging-materials', ['id' => $product->id]) }}">
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
                                            <a href="{{ route('deduct-packaging-materials', ['id' => $product->id]) }}">
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
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
</div>

