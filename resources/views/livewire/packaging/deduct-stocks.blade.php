<div class="p-6 text-gray-900">
    <table class="w-full">
        <caption class="text-4xl border-b-2 border-pink-700">
            <b>Details - {{ $get_material->id }}</b>
        </caption>
        <thead class="text-4xl border-b-2 border-pink-700">
            <tr>
                <th></th>
            </tr>
        </thead>
        <tbody class="text-xl odd:bg-slate-200">
            <tr>
                <td><b>Name:</b> {{ $get_material->name }}</td>
                <td><b>Stocks:</b> {{ $get_material->total_stocks }}</td>
            </tr>
            <tr>
                <td><b>Size:</b> {{ $get_material->size }}</td>
                <td><b>Released Stocks:</b> {{ $get_material->released_stocks }}</td>
            </tr>
        </tbody>
    </table>
    <div class="flex justify-center items-center m-2 w-full">
        <form wire:submit.prevent="store" class="w-1/2 flex justify-between">
            @csrf
            <table class="w-full">
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="number" wire:model="stocks"
                                class="w-full border-2 rounded-xl" placeholder="Stocks" />
                            @if ($errors->any() && $errors->has('stocks'))
                            <span class="error text-red-600">{{ $errors->first('stocks') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit"
                                class="w-full p-2 pl-4 pr-4 bg-red-600 text-white rounded-full">
                                DEDUCT
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>