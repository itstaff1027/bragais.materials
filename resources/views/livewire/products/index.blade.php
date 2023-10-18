<div>
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
                <input class="border-2 border-violet-700 rounded-l-full w-1/2 p-2 m-0"
                    wire:model.live.debounce.500ms='product_sku_search' placeholder="Search Stock [Product SKU]" />
                <button class="border-2 border-violet-700 rounded-r-full p-2 m-0" @click="open = ! open">Filter</button>
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
                <td>
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
</div>