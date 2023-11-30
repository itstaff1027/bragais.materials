<div>
    <table class="w-full">
        <caption class="text-4xl border-b-2 border-pink-700">
            <b>Outgoin Product? ID:{{ $product->id }}</b>
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
        <form wire:submit.prevent="putOutgoingProduct" class="w-full justify-between flex">
            @csrf
            {{-- <select wire:model="packaging_type" class="rounded-full">
                <option value="COMPLETE_PACKAGING">COMPLETE_PACKAGING<option>
                <option value="DUSTBAG_ONLY">DUSTBAG ONLY</option
            </select> --}}
            <div class="w-1/8 flex flex-col">
                <label class="font-bold">Order Number</label>
                <input type="number" wire:model="order_number" />
                @if ($errors->any() && $errors->has('order_number'))
                    <span class="error text-red-600">{{ $errors->first('order_number') }}</span>
                @endif
            </div>
            <div class="w-1/8 flex flex-col">
                <label class="font-bold">Quantity</label>
                <input type="number" wire:model="quantity" />
                @if ($errors->any() && $errors->has('quantity'))
                    <span class="error text-red-600">{{ $errors->first('quantity') }}</span>
                @endif
            </div>
            <div class="w-1/8 flex justify-center items-center">
                <button type="submit"
                    class="w-full p-2 pl-4 pr-4 bg-emerald-600 text-white rounded-full">
                    ADD
                </button>
            </div>
        </form>
        <a href="{{ route('products') }}" class="p-4">
            <button class="w-full p-2 pl-4 pr-4 bg-blue-900 text-white rounded-full">
                GO BACK
            </button>
        </a>
    </div>
</div>