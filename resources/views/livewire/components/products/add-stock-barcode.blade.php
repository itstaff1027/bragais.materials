<div class="flex flex-col justify-center items-center">
    <div class="flex flex-col justify-center items-center" x-data="{ open: false, success: false  }">
        <button x-on:click="open = ! open ">Toggle Dropdown</button>
        <div x-show="success">
            <div 
                class="alert alert-success text-emerald-500 font-bold"
            >
                <!-- Your success message content goes here -->
            </div>
        </div>
        <div x-show="open">
            <div class="h-52 w-72 m-4" id="barcode-scanner"></div>
        </div>
    </div>
    
    <div x-text="$wire.successMessage"></div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barcodeLists as $list)
                <tr>
                    <td>{{ $list->barcode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
