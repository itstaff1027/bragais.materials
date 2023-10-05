<x-app-layout>
    <x-slot name="header">
        <div class="w-full border-2 border-teal-500"> sstest</div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="w-full border-2"> sstest</div>
                    <livewire:inventory.index />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>