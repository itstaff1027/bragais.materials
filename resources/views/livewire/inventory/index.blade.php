<div>
    <div class="flex flex-col"  x-data="{ open: false }">
        <div class="flex justify-between w-full">
            <div class="flex justify-between">
                <button @click="open = ! open">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('add-new-material') }}" class="m-2">
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
                <a href="{{ route('product-development-progress') }}" class="m-2">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fff957}</style><path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z"/></svg>
                    </button>
                </a>
            </div>
        </div>
        <form class="w-full flex" >
            @csrf
            <div class="w-full flex flex-col md:flex-row md:h-56" x-show="open" x-transition.duration.500ms>
                <div class=" w-full bg-white drop-shadow-2xl rounded-xl p-4 md:w-1/2 overflow-x-auto">
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="border-2 text-center">
                                <td>Material SKU</td>
                                <td>Name</td>
                                <td>Color</td>
                                <td>Quantity</td>
                                <td>||</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $index => $item)
                                <tr key="{{ $item['id'] }}" class=" text-center ">
                                    <td class="border-2">{{ $item['material_sku'] }}</td>
                                    <td class="border-2">{{ $item['name'] }}</td>
                                    <td class="border-2">{{ $item['color'] }}</td>
                                    <td class="border-2">
                                        <input type="number" wire:model.blur='cart.{{ $index }}.quantity' class="w-full text-center border-none p-0 rounded-lg bg-slate-200" placeholder='{{ $item['quantity'] }}' />
                                    </td>
                                    <td>
                                        <button wire:click.prevent="removeFromCart({{ $index }})">
                                            REMOVE
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                <div class=" bg-white drop-shadow-2xl rounded-xl p-4 w-full md:w-1/2">
                    <div class="w-full h-full flex flex-col">
                        <select wire:model='status' class="rounded-xl border-slate-500 m-2">
                            <option disabled>CHOOSE</option>
                            <option value="DELIVER">DELIVER</option>
                        </select>
                        <textarea type="text" wire:model='remarks' class="rounded-xl border-slate-500 m-2" placeholder="Remarks"></textarea>
                        <button type="submit" wire:submit.prevent='store' class="m-2 rounded-lg p-2 bg-emerald-300">
                            SUBMIT
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
    
   
    <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
        <caption>
            <h1 class="italic text-xl font-bold p-2">All Materials
            </h1>
            <div class="m-2" x-data="{ open: false }">
                <input class="border-2 border-violet-700 rounded-l-full w-1/2 p-2 m-0"
                    wire:model.live.debounce.500ms='material_sku_search' placeholder="Search Stock [material SKU]" />
                <button class="border-2 border-violet-700 rounded-r-full p-2 m-0" @click="open = ! open">Filter</button>
                {{-- FILTER --}}
                <div class="m-2" x-show="open" x-transition.duration.500ms>
                    <input class="border-2 border-violet-700 rounded-full w-1/8 m-2"
                        wire:model.live.debounce.500ms='type_search' placeholder="Type" />
                    <input class="border-2 border-violet-700 rounded-full w-1/8 m-2"
                        wire:model.live.debounce.500ms='name_search' placeholder="Name" />
                    <input class="border-2 border-violet-700 rounded-full w-1/8 m-2"
                        wire:model.live.debounce.500ms='color_search' placeholder="Color" />
                    <input class="border-2 border-violet-700 rounded-full w-1/8 m-2"
                        wire:model.live.debounce.500ms='size_search' placeholder="Size" />
                </div>

            </div>
        </caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Material SKU</th>
                <th>Type</th>
                <th>Name</th>
                <th>Color</th>
                <th>Size</th>
                <th>Unit Per</th>
                <th>Stocks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materials as $material)
            <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200" >
                <td class="p-2">{{ $material->id }}</td>
                <td>{{ $material->material_sku }}</td>
                <td>{{ $material->type }}</td>
                <td>{{ $material->name }}</td>
                <td>{{ $material->color }}</td>
                <td>{{ $material->size }}</td>
                <td>{{ $material->unit_per }}</td>
                <td>{{ $material->total_stocks }}</td>
                <td>
                    <button wire:click='addToCart({{ $material }})'>
                        ADD
                    </button>
                    <a href="{{ route('update-material-details', ['id' => $material->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#4173c8}</style><path d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6z"/></svg>
                        </button>
                    </a>
                    {{-- <a href="{{ route('add-material-stocks', ['id' => $material->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#975326}</style><path d="M50.7 58.5L0 160H208V32H93.7C75.5 32 58.9 42.3 50.7 58.5zM240 160H448L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240V160zm208 32H0V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192z"/></svg>
                        </button>
                    </a> --}}
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="p-3">
        {{ $materials->links() }}
    </div>
</div>