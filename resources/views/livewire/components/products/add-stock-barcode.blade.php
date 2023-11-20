<div class="flex flex-col justify-center items-center" x-data="{ isSuccess: @entangle('is_success'), isError: @entangle('is_error') }">
    
    <div x-show="$nextTick(() => { 
        if($wire.is_success){
            setTimeout(() => { 
                $wire.is_success = false; 
                isSuccess = false;
            }, 3000);
        }
        
    })" >
        <div 
            x-show="isSuccess"
            class="alert alert-success text-emerald-500 font-bold"
            x-text="$wire.successMessage"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-400"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
        >
        </div>
    </div>

    <div 
        x-show="$nextTick(() => { 
            if($wire.is_error){
                setTimeout(() => { 
                    $wire.is_error = false; 
                    isError = false;
                }, 3000);
            }
            
        })" 
    >
        <div 
            x-show="isError"
            class="alert alert-error text-red-500 font-bold"
            x-text="$wire.errorMessage"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-400"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
        >
        </div>
    </div>
    
    <div class="flex flex-col justify-center items-center" x-data="{ open: false }">
        <button x-on:click="open = ! open ">Scan and Add</button>
        <div class="h-52 w-72 m-4" x-show="open">
            <div class="m-4" id="barcode-scanner"></div>
        </div>
    </div>

    <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
        <thead>
            <tr>
                <th>Date</th>
                <th>Barcode ID</th>
                <th>Barcode Name</th>
                <th>Model</th>
                <th>Color</th>
                <th>Size</th>
                <th>Heel Height</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barcodeLists as $added)
                <tr>
                    <td>{{ $added->updated_at }}</td>
                    <td>{{ $added->id }}</td>
                    <td>{{ $added->barcode }}</td>
                    <td>{{ $added->model }}</td>
                    <td>{{ $added->color }}</td>
                    <td>{{ $added->size }}</td>
                    <td>{{ $added->heel_height }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
