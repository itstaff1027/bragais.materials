<div>
    <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
        <caption>
            <h1 class="italic text-xl font-bold p-2">All Materials
                {{-- <a href="{{ route('add-new-material') }}">
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
            <tr class="hover:bg-violet-900 hover:text-white odd:bg-gray-200">
                <td class="p-2">{{ $material->id }}</td>
                <td>{{ $material->material_sku }}</td>
                <td>{{ $material->type }}</td>
                <td>{{ $material->name }}</td>
                <td>{{ $material->color }}</td>
                <td>{{ $material->size }}</td>
                <td>{{ $material->unit_per }}</td>
                <td>{{ $material->total_stocks }}</td>
                <td>
                    {{-- <div x-data="{ modal_open: false }">
                        <button @click="modal_open = ! modal_open">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                class="fill-green-400">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                </style>
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                        </button>

                        <div x-show="modal_open"
                            class="absolute text-black p-2 bg-violet-400 rounded-full ring-offset-2 border-2 border-pink-300">
                            <a href="{{ route('add-stocks', ['id' => $material->id]) }}">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                        class="fill-amber-700">
                                        <path
                                            d="M50.7 58.5L0 160H208V32H93.7C75.5 32 58.9 42.3 50.7 58.5zM240 160H448L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240V160zm208 32H0V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="{{ route('add-outlet_stocks', ['id' => $material->id]) }}">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                        class="fill-red-600">
                                        <path
                                            d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="{{ route('add-display_stocks', ['id' => $material->id]) }}">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"
                                        class="fill-brown-200">
                                        <path
                                            d="M175.2 476.6c-9.7-18-15.2-38.7-15.2-60.6c0-40.3 19-78.2 51.2-102.4l64-48c8.1-6 12.8-15.5 12.8-25.6V96H128V240c0 20.1-9.5 39.1-25.6 51.2l-64 48C14.2 357.3 0 385.8 0 416c0 53 43 96 96 96c20.8 0 41-6.7 57.6-19.2l21.6-16.2zM128 64H288V48c0-14.5 3.9-28.2 10.7-39.9C291 3 281.9 0 272 0H176c-26.5 0-48 21.5-48 48V64zM320 96V240c0 20.1-9.5 39.1-25.6 51.2l-64 48C206.2 357.3 192 385.8 192 416c0 53 43 96 96 96c20.8 0 41-6.7 57.6-19.2l115.2-86.4C493 382.2 512 344.3 512 304V96H320zM512 64V48c0-26.5-21.5-48-48-48H368c-26.5 0-48 21.5-48 48V64H512z" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div> --}}

                    {{-- <a href="{{ route('edit-model', ['id' => $material->id]) }}">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"
                                class="fill-blue-600">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M368.4 18.3L312.7 74.1 437.9 199.3l55.7-55.7c21.9-21.9 21.9-57.3 0-79.2L447.6 18.3c-21.9-21.9-57.3-21.9-79.2 0zM288 94.6l-9.2 2.8L134.7 140.6c-19.9 6-35.7 21.2-42.3 41L3.8 445.8c-3.8 11.3-1 23.9 7.3 32.4L164.7 324.7c-3-6.3-4.7-13.3-4.7-20.7c0-26.5 21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48c-7.4 0-14.4-1.7-20.7-4.7L33.7 500.9c8.6 8.3 21.1 11.2 32.4 7.3l264.3-88.6c19.7-6.6 35-22.4 41-42.3l43.2-144.1 2.8-9.2L288 94.6z" />
                            </svg>
                        </button>
                    </a> --}}

                    {{-- <div x-data="{ modal_open_delete: false }">
                        <button @click="modal_open_delete = ! modal_open_delete">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"
                                class="fill-red-500">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M576 128c0-35.3-28.7-64-64-64H205.3c-17 0-33.3 6.7-45.3 18.7L9.4 233.4c-6 6-9.4 14.1-9.4 22.6s3.4 16.6 9.4 22.6L160 429.3c12 12 28.3 18.7 45.3 18.7H512c35.3 0 64-28.7 64-64V128zM271 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                            </svg>
                        </button>
                        <div x-show="modal_open_delete"
                            class="absolute text-black p-2 bg-violet-400 rounded-full ring-offset-2 border-2 border-pink-300 w-1/4 right-14">
                            <div class="flex flex-col justify-center items-center">
                                <h1>Are you sure you want to delete this material ?</h1>
                                <button wire:click="delete({{ $material->id }})"
                                    class="w-1/2 bg-emerald-600 text-white rounded-full">Yes</button>
                            </div>
                        </div>

                    </div> --}}
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="p-3">
        {{ $materials->links() }}
    </div>
</div>