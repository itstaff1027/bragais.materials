<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Add New Product") }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex flex-col justify-center items-center w-full">
                        <h1 class="text-xl font-bold">Create new Material</h1>
                        <div class="p-2 flex justify-center items-center w-1/2">
                            <form wire:submit.prevent="store" class="w-full flex flex-col justify-center items-center">
                                @csrf

                                @php
                                    $productInputArr = [
                                        ['model' => 'product_sku', 'placeholder' => 'Product SKU [CHAGLO]', 'error' => 'product_sku'],
                                        ['model' => 'product_category', 'placeholder' => 'Product Category [PAGEANT, HEEL, and so on]', 'error' => 'product_category'],
                                        ['model' => 'product_model', 'placeholder' => 'Product Model', 'error' => 'product_model'],
                                        ['model' => 'product_color', 'placeholder' => 'Product color', 'error' => 'product_color'],
                                        ['model' => 'product_heel_height', 'placeholder' => 'Product Heel Height', 'error' => 'product_heel_height'],
                                        ['model' => 'product_price', 'placeholder' => 'Product Price', 'error' => 'product_price'],
                                    ]
                                @endphp

                                <label>US</label>
                                <input type="radio" value="US" wire:model="size_type" /> 
                                <label>EURO</label>
                                <input type="radio" value="EURO" wire:model="size_type" />

                                @if ($errors->has('size_type')) <!-- Fixed this line -->
                                <span class="error text-red-600">{{ $errors->first('size_type') }}</span> <!-- Fixed this line -->
                                @endif

                                @foreach ($productInputArr as $inputs)
                                <input type="text" wire:model="{{ $inputs['model'] }}"
                                    class="w-full rounded-xl m-1" placeholder="{{ $inputs['placeholder'] }}" />

                                @if ($errors->has($inputs['error'])) <!-- Fixed this line -->
                                    <span class="error text-red-600">{{ $errors->first($inputs['error']) }}</span> <!-- Fixed this line -->
                                @endif
                                @endforeach

                                
                                <div class="w-1/2 flex justify-center items-center">
                                    <button class="rounded-full bg-emerald-500 text-white p-2 w-1/4 m-2">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</x-app-layout>
</div>