<table class="overflow-y table-auto w-full text-center divide-y-2 border-2 ">
    <caption>
        <h1 class="font-bold text-2xl">Summary</h1>
    </caption>
    <thead>
        <tr class=" border-2 ">
            <th class="w-28">Order Number</th>
            <th class="w-28">Customer </th>
            <th class="w-28">Model</th>
            <th class="w-28">Color</th>
            <th class="w-28">Size</th>
            <th class="w-28">Heel Height</th>
            <th class="w-28">Heel Type</th>
            <th class="w-28">Round</th>
            <th class="w-28">Packaging Type</th>
            <th class="w-28">Sold Date</th>
            <th class="w-28">Remarks</th>
            <th class="w-28">Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($MTOs as $MTO)
            <tr>
                <td>{{ $MTO->order_number }}</td>
                <td>{{ $MTO->customer_details }}</td>
                <td>{{ $MTO->model }}</td>
                <td>{{ $MTO->color }}</td>
                <td>{{ $MTO->size }}</td>
                <td>{{ $MTO->heel_height }}</td>
                <td>{{ $MTO->heel_type }}</td>
                <td>{{ $MTO->round }}</td>
                <td>{{ $MTO->packaging_type }}</td>
                <td>{{ $MTO->sold_date }}</td>
                <td>{{ $MTO->remarks }}</td>
                <td>{{ $MTO->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>