<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Add TO DO") }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" x-data="{ open: false }">
                        <input type="text" class="w-full border-none hover:border-blue-400 rounded-xl" placeholder="Title" />
                        <hr>
                        <div class="flex justify-between p-4">
                            <h1 class="font-bold">Product</h1>
                            <div class="cursor-pointer w-1/8 rounded-xl p-1 bg-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                    class="fill-gray-300">
                                    <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    </style>
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                </svg>
                            </div>
                        </div>
                        <hr>
                        
                    </div>  
                </div>
            </div>
        </div>
    </x-app-layout>
</div>