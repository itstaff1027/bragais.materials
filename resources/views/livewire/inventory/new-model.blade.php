<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Add New Material") }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" x-data="{ open: false }">

                        <form wire:submit.prevent="update" class="w-full flex flex-col justify-center items-center">
                            <table class="w-full">
                                <thead class="text-4xl border-b-2 border-pink-700">
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-xl odd:bg-slate-200">
                                    <tr>
                                        <td>
                                            <b>Material SKU:</b>
                                            <input type="text" wire:model="material_sku"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="Material SKU [FBRCND]" />
                                            @if($errors->any() && $errors->has('material_sku'))
                                            <span class="error text-red-600">{{ $errors->first('material_sku') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <b>Unit Per:</b>
                                            <input type="text" wire:model="unit_per"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="{{ $get_material->unit_per }}" />
                                            @if($errors->any() && $errors->has('unit_per'))
                                            <span class="error text-red-600">{{ $errors->first('unit_per') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Name:</b>
                                            <input type="text" wire:model="name"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="{{ $get_material->name }}" />
                                            @if($errors->any() && $errors->has('name'))
                                            <span class="error text-red-600">{{ $errors->first('name') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <b>Type:</b>
                                            <input type="text" wire:model="type"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="{{ $get_material->type }}" />
                                            @if($errors->any() && $errors->has('type'))
                                            <span class="error text-red-600">{{ $errors->first('type') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Color:</b>
                                            <input type="text" wire:model="color"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="{{ $get_material->color }}" />
                                            @if($errors->any() && $errors->has('color'))
                                            <span class="error text-red-600">{{ $errors->first('color') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <b>Size:</b>
                                            <input type="text" wire:model="size"
                                                class="bg-slate-200 hover:bg-white border-none"
                                                placeholder="{{ $get_material->size }}" />
                                            @if($errors->any() && $errors->has('size'))
                                            <span class="error text-red-600">{{ $errors->first('size') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>
                                                Stocks: &nbsp;
                                            </b>
                                            {{ $get_material->total_stocks }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="p-2">
                                <button type="submit"
                                    class="w-full p-2 pl-8 pr-8 pr-4transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 bg-violet-950 text-white rounded-full mb-2">
                                    Save
                                </button>
                            </div>
                        </form>

                        <div class="p-2">
                            <form wire:submit.prevent="store">
                                @csrf
                                <table class="w-full" x-show="open" x-transition.duration.500ms>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="number" wire:model="stocks"
                                                    class="w-full border-2 rounded-xl" placeholder="Stocks" />
                                                @error('stocks')<span class="error text-red-600">{{ $message
                                                    }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea wire:model="remarks" class="w-full border-2 rounded-xl"
                                                    placeholder="Remarks"></textarea>
                                                @error('remarks')<span class="error text-red-600">{{ $message
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
                        </div>
                    </div>

                    {{-- <div class="flex justify-center items-center m-2 w-full">
                        <form wire:submit.prevent="postDisplayStocks" class="w-1/4 flex justify-between">
                            @csrf
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="number" wire:model="stocks" class="w-full border-2 rounded-xl"
                                                placeholder="Stocks" />
                                            @error('stocks')<span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <textarea wire:model="remarks" class="w-full border-2 rounded-xl"
                                                placeholder="Remarks"></textarea>
                                            @error('remarks')<span class="error text-red-600">{{ $message }}</span>
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
                    </div> --}}
                </div>
            </div>
        </div>
</div>
</x-app-layout>
</div>