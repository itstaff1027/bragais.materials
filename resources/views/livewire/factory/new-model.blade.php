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
                    <div class="p-6 text-gray-900 flex flex-col justify-center items-center w-full">
                        <h1 class="text-xl font-bold">Create new Material</h1>
                        <div class="p-2 flex justify-center items-center w-1/2">
                            <form wire:submit.prevent="store" class="w-full flex flex-col justify-center items-center">
                                @csrf

                                @php
                                    $materialInputArr = [
                                        ['model' => 'material_sku', 'placeholder' => 'Material SKU [FBRCNDGLSSY]', 'error' => 'material_sku'],
                                        ['model' => 'material_type', 'placeholder' => 'Material type [FABRIC, HEEL, and so on]', 'error' => 'material_type'],
                                        ['model' => 'material_name', 'placeholder' => 'Material name', 'error' => 'material_name'],
                                        ['model' => 'material_color', 'placeholder' => 'Material color', 'error' => 'material_color'],
                                        ['model' => 'material_size', 'placeholder' => 'Material size', 'error' => 'material_size'],
                                        ['model' => 'material_unit', 'placeholder' => 'Material unit', 'error' => 'material_unit'],
                                    ]
                                @endphp

                                @foreach ($materialInputArr as $inputs)
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