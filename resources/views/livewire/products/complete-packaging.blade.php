<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Complete Packaging') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full">
                            <caption class="text-4xl border-b-2 border-pink-700">
                                <b>Do you want to add a Complete Packaing Record to this Product? ID:{{ $product->id
                                    }}</b>
                            </caption>
                            <thead class="text-4xl border-b-2 border-pink-700">
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-xl odd:bg-slate-200">
                                <tr>
                                    <td><b>Product SKU:</b> {{ $product->product_sku }}</td>
                                    <td><b>Category:</b> {{ $product->category }}</td>
                                </tr>
                                <tr>
                                    <td><b>Model:</b> {{ $product->model }}</td>
                                    <td><b>Size:</b> {{ $product->size }}</td>
                                </tr>
                                <tr>
                                    <td><b>Color:</b> {{ $product->color }}</td>
                                    <td><b>Heel Height:</b> {{ $product->heel_height }}</td>
                                </tr>
                                <tr>
                                    <td><b>Price:</b> {{ $product->price }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex flex-col justify-center items-center m-2 w-full">
                            <form wire:submit.prevent="store" class="w-full justify-between flex border-2">
                                @csrf
                                {{-- <select wire:model="packaging_type" class="rounded-full">
                                    <option value="COMPLETE_PACKAGING">COMPLETE_PACKAGING<option>
                                    <option value="DUSTBAG_ONLY">DUSTBAG ONLY</option
                                </select> --}}
                                <input type="number" wire:model="order_number" />
                                <button type="submit"
                                    class="w-1/4 p-2 pl-4 pr-4 bg-emerald-600 text-white rounded-full">
                                    ADD
                                </button>
                            </form>
                            <a href="{{ route('products') }}" class="p-4">
                                <button class="w-full p-2 pl-4 pr-4 bg-blue-900 text-white rounded-full">
                                    GO BACK
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>