<div  x-data="{ open: false }">
    {{-- <div class="flex justify-end">
        <button @click="open = ! open"
            class="transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300 text-white rounded-full p-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                class="fill-green-400">
                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                </style>
                <path
                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
            </svg>
        </button>
    </div> --}}

    <form wire:submit.prevent="update" class="w-full flex flex-col justify-center items-center">
        <table class="w-full">
            <caption class="text-4xl border-b-2 border-pink-700">
                <b>Details - {{ $product->id }}</b>
                <h1>IMAGE</h1>
            </caption>
            <thead class="text-4xl border-b-2 border-pink-700">
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-xl odd:bg-slate-200">
                <tr>
                    <td>
                        <b>Product SKU:</b>
                        <input type="text" wire:model="product_sku"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->product_sku }}" />
                        @if($errors->any() && $errors->has('product_sku'))
                        <span class="error text-red-600">{{ $errors->first('product_sku') }}</span>
                        @endif
                    </td>
                    <td>
                        <b>Size:</b>
                        <input type="text" wire:model="size"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->size }}" />
                        @if($errors->any() && $errors->has('size'))
                        <span class="error text-red-600">{{ $errors->first('size') }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Model:</b>
                        <input type="text" wire:model="model"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->model }}" />
                        @if($errors->any() && $errors->has('model'))
                        <span class="error text-red-600">{{ $errors->first('model') }}</span>
                        @endif
                    </td>
                    <td>
                        <b>Heel Height:</b>
                        <input type="text" wire:model="heel_height"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->heel_height }}" />
                        @if($errors->any() && $errors->has('heel_height'))
                        <span class="error text-red-600">{{ $errors->first('heel_height') }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Color:</b>
                        <input type="text" wire:model="color"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->color }}" />
                        @if($errors->any() && $errors->has('color'))
                        <span class="error text-red-600">{{ $errors->first('color') }}</span>
                        @endif
                    </td>
                    <td>
                        <b>Category:</b>
                        <input type="text" wire:model="category"
                            class="bg-slate-200 hover:bg-white border-none"
                            value="{{ $product->category }}" />
                        @if($errors->any() && $errors->has('category'))
                        <span class="error text-red-600">{{ $errors->first('category') }}</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="w-full flex justify-center items-center">
            <h1 class="underline"><b>Stocks:</b> _ <b class="{{ $product->total_stocks <= 3 ? 'text-red-500' : 'text-emerald-500' }}">{{ $product->total_stocks ? $product->total_stocks : 0  }}</b></h1>
        </div>
        <div class="p-2">
            <button type="submit"
                class="w-full p-2 pl-8 pr-8 pr-4transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 bg-violet-950 text-white rounded-full mb-2">
                Save
            </button>
        </div>
    </form>

    <div class="p-2 flex border-2">
        <form wire:submit.prevent="storeAddStocks" class="w-1/2 flex justify-center items-center border-2">
            @csrf
            <table class="w-1/2 m-2">
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="number" wire:model="addStocks"
                                class="w-full border-2 rounded-xl" placeholder="Add Stocks" />
                            @error('addStocks')<span class="error text-red-600">{{ $message
                                }}</span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea wire:model="addRemarks" class="w-full border-2 rounded-xl"
                                placeholder="Remarks"></textarea>
                            @error('addRemarks')<span class="error text-red-600">{{ $message
                                }}</span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit"
                                class="w-full p-2 pl-4 pr-4 bg-emerald-600 text-white rounded-full">
                                ADD
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <form wire:submit.prevent="storeReduceStocks" class="w-1/2 flex justify-center items-center border-2">
            @csrf
            <table class="w-1/2 m-2" >
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="number" wire:model="reduceStocks"
                                class="w-full border-2 rounded-xl" placeholder="Reduce Stocks" />
                            @error('reduceStocks')<span class="error text-red-600">{{ $message
                                }}</span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea wire:model="reduceRemarks" class="w-full border-2 rounded-xl"
                                placeholder="Remarks"></textarea>
                            @error('reduceRemarks')<span class="error text-red-600">{{ $message
                                }}</span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit"
                                class="w-full p-2 pl-4 pr-4 bg-red-600 text-white rounded-full">
                                REDUCE
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>