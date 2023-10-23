<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Product Development Progress") }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex flex-col justify-center items-center w-full">
                        <h1 class="text-xl font-bold">Progress</h1>
                        <div class="w-full h-96 flex overflow-x-auto bg-slate-900 p-2 rounded-lg mt-4">
                            @php
                                $progressArr = [
                                    ['wire:submit' => 'updateHistory', 'title' => 'HISTORY', 'status' => 'HISTORY'],
                                    ['wire:submit' => 'updateToDo', 'title' => 'TODO', 'status' => 'TODO'],
                                    ['wire:submit' => 'updateOnGoing', 'title' => 'ON GOING', 'status' => 'ONGOING'],
                                    ['wire:submit' => 'updateDone', 'title' => 'DONE', 'status' => 'DONE'],
                                    ['wire:submit' => 'updateToDeliver', 'title' => 'TO DELIVER', 'status' => 'TODELIVER'],
                                    ['wire:submit' => 'updateDelivered', 'title' => 'DELIVERED', 'status' => 'DELIVERED'],
                                ]
                            @endphp

                            @php
                            $testArr = [
                                ['wire:submit' => 'updateHistory', 'title' => 'HISTORY', 'status' => 'HISTORY'],
                                ['wire:submit' => 'updateToDo', 'title' => 'TODO', 'status' => 'TODO'],
                                ['wire:submit' => 'updateOnGoing', 'title' => 'ON GOING', 'status' => 'ONGOING'],
                                ['wire:submit' => 'updateDone', 'title' => 'DONE', 'status' => 'DONE'],
                                ['wire:submit' => 'updateToDeliver', 'title' => 'TO DELIVER', 'status' => 'TODELIVER'],
                                ['wire:submit' => 'updateDone', 'title' => 'TT', 'status' => 'DONE'],
                                ['wire:submit' => 'updateToDeliver', 'title' => 'DDD', 'status' => 'TODELIVER'],
                                ['wire:submit' => 'updateDelivered', 'title' => 'DELIVERED', 'status' => 'DELIVERED'],
                            ]
                            @endphp
                            @foreach ($progressArr as $progress)
                                <div class="w-96 m-2  rounded-tl-2xl">
                                    <form wire:submit.prevent="{{ $progress['wire:submit'] }}" class="max-h-full w-80">
                                        <div class="w-full p-2 flex justify-center items-center bg-yellow-500 rounded-tl-xl font-bold">
                                            <h1>{{ $progress['title'] }}</h1>

                                            @if ($progress['status'] == 'TODO')
                                                <a class="ml-2">
                                                    <button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                                            class="fill-gray-900">
                                                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            </style>
                                                            <path
                                                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                        </svg>
                                                    </button>
                                                </a>   
                                            @endif
                                            
                                        </div>
                                        <div class="border-2 max-h-full w-full rounded-b-xl">
                                            <div class="max-h-72 w-full p-2  text-white overflow-y-auto">
                                                @foreach ($testArr as $test)
                                                    @if ($test['status'] == $progress['status'])
                                                        <div class="m-1.5 mb-4 p-3 bg-gray-400 rounded-xl">
                                                            <button></button>
                                                        </div>
                                                    @endif
                                                    
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</x-app-layout>
</div>