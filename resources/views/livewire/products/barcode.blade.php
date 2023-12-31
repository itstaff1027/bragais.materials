<div>
    <button id="printButton">Print</button>
    <table class="table-auto w-full text-center divide-y-2 divide-violet-400 hover:divide-pink-400">
        <thead>
            <tr>
                <th>Created At</th>
                <th>Product ID</th>
                <th>Model</th>
                <th>Color</th>
                <th>Size</th>
                <th>Heel Height</th>
                <th>Category</th>
                <th>Barcode ID</th>
                <th>Barcode Name</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barcodes as $barcode)
                <tr>
                    <td>{{ $barcode->created_at }}</td>
                    <td>{{ $barcode->id }}</td>
                    <td>{{ $barcode->model }}</td>
                    <td>{{ $barcode->color }}</td>
                    <td>{{ $barcode->size }}</td>
                    <td>{{ $barcode->heel_height }}</td>
                    <td>{{ $barcode->category }}</td>
                    <td>{{ $barcode->barcode_id }}</td>
                    <td>{{ $barcode->barcode }}</td>
                    <td><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG("$barcode->barcode_id", 'C128') }}" alt="Barcode"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3">
        {{ $barcodes->links() }}
    </div>
    <livewire:components.products.print-barcode />
</div>