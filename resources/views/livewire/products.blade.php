<div>
    <div class="flex flex-col"  x-data="{ open: false }">
        <div class="flex justify-between w-full">
            <div class="flex justify-between">
                <button @click="open = ! open">
                    <svg class="fill-slate-700" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('product_add-model') }}" class="m-2">
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
                {{-- <a href="{{ route('product-development-progress') }}" class="m-2">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fff957}</style><path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z"/></svg>
                    </button>
                </a> --}}
            </div>
        </div>
        <form wire:submit.prevent='store' class="w-full flex" >
            @csrf
            <div class="w-full flex flex-col md:flex-row md:h-56" x-show="open" x-transition.duration.500ms>
                <div class=" w-full bg-white drop-shadow-2xl rounded-xl p-4 md:w-1/2 overflow-x-auto">
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="border-2 text-center">
                                <td>Product SKU</td>
                                <td>Model</td>
                                <td>Color</td>
                                <td>Quantity</td>
                                <td>||</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $index => $item)
                                <tr key="{{ $item['id'] }}" class=" text-center ">
                                    <td class="border-2">{{ $item['product_sku'] }}</td>
                                    <td class="border-2">{{ $item['model'] }}</td>
                                    <td class="border-2">{{ $item['color'] }}</td>
                                    <td class="border-2">
                                        <input type="number" wire:model.blur='cart.{{ $index }}.quantity' class="w-full text-center border-none p-0 rounded-lg bg-slate-200" placeholder='{{ $item['quantity'] }}' />
                                    </td>
                                    <td>
                                        <button wire:click.prevent="removeFromCart({{ $index }})">
                                            <svg class="fill-red-500" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                <div class=" bg-white drop-shadow-2xl rounded-xl p-4 w-full md:w-1/2">
                    <div class="w-full h-full flex flex-col">
                        {{-- <select wire:model='status' class="rounded-xl border-slate-500 m-2">
                            <option disabled>CHOOSE</option>
                            <option value="DELIVER">DELIVER</option>
                        </select>
                        <textarea type="text" wire:model='remarks' class="rounded-xl border-slate-500 m-2" placeholder="Remarks"></textarea>
                        <button type="submit" class="m-2 rounded-lg p-2 bg-emerald-300">
                            SUBMIT
                        </button> --}}
                    </div>
                </div>
            </div>
        </form>
        
    </div>
    <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
        <caption>
            <h1 class="italic text-xl font-bold p-2">All Products
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
            <div class="m-2" x-data="{ open: false }">
                <input class="border-2 border-violet-700 rounded-l-full rounded-r-md w-1/2 p-2 m-0"
                    wire:model.live.debounce.500ms='product_sku_search' placeholder="Search Stock [Product SKU]" />
                <button class="border-2 border-violet-700 rounded-md p-2 m-0" @click="open = ! open">Filter</button>
                <button class="border-2 border-violet-700 rounded-md p-2 m-0" wire:click="filterStocks(0)">All</button>
                <button class="border-2 border-violet-700 rounded-l-md p-2 m-0" wire:click="filterStocks(1)">Stocks</button>
                <button class="border-2 border-violet-700 rounded-l-md rounded-r-full p-2 m-0" wire:click="filterStocks(-1)">-Stocks</button>
                {{-- FILTER --}}
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

            </div>
        </caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product SKU</th>
                <th>Model</th>
                <th>Color</th>
                <th>Size</th>
                <th>Heel Height</th>
                <th>Category</th>
                <th>Stocks</th>
                <th>Outlet Stocks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200">
                <td class="p-2">{{ $product->id }}</td>
                <td>{{ $product->product_sku }}</td>
                <td>{{ $product->model }}</td>
                <td>{{ $product->color }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->heel_height }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->product_total_stocks }}</td>
                <td>{{ $product->outlet_product_total_stocks }}</td>
                <td>
                    <a href="{{ route('generate-barcode-product', ['id' => $product->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/></svg>
                        </button>
                    </a>
                    <button wire:click='addToCart({{ $product }})' class="text-emerald-500">
                        <svg class="fill-emerald-500" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48H69.5c3.8 0 7.1 2.7 7.9 6.5l51.6 271c6.5 34 36.2 58.5 70.7 58.5H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H199.7c-11.5 0-21.4-8.2-23.6-19.5L170.7 288H459.2c32.6 0 61.1-21.8 69.5-53.3l41-152.3C576.6 57 557.4 32 531.1 32H360V134.1l23-23c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-64 64c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l23 23V32H120.1C111 12.8 91.6 0 69.5 0H24zM176 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm336-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z"/></svg>
                    </button>
                    <a href="{{ route('update-product', ['id' => $product->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#4173c8}</style><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6z"/></svg>
                        </button>
                    </a>
                    <a href="{{ route('complete-packaging', ['id' => $product->id]) }}">
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
                    <a href="{{ route('outgoing-products', ['id' => $product->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>svg{fill:#974e35}</style>
                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                            </svg>
                        </button>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="p-3">
        {{ $products->links() }}
    </div>

    <livewire:components.products.add-stock-barcode />
    
    {{-- <div>
        <h1> DO NOT THIS CLICK THIS BUTTON IT WILL TEAR APART THE SYSTEM THANKS!!!!</h1>
        <h1>PROMISE!</h1>
        <button wire:click="addThisStocks">
            ADD THIS STOCKS
        </button>
    </div> --}}
</div>