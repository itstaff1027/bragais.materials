<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Packaging') }}
            </h2>
            <a href="{{ route('packaging-per-day') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                {{ __('Per Day') }}
            </a>
            <a href="{{ route('summary-materials') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                {{ __('Summary') }}
            </a>
            <a href="{{ route('material-logs') }}" class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                {{ __('Material Logs') }}
            </a>
        </div>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:packaging.index />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>