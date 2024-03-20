<table class="overflow-y table-auto w-full text-center divide-y-2 border-2 ">
    <caption>
        <h1 class="font-bold text-2xl">Summary</h1>
    </caption>
    <thead>
        <tr class=" border-2 ">
            <th class="w-28">Order Number</th>
            <th class="w-28">Customer </th>
            <th class="w-28">Order Lists</th>
            <th class="w-28">Packaging Type</th>
            <th class="w-28">Sold Date</th>
            <th class="w-28">Remarks</th>
            <th class="w-28">Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pullouts as $pullout)
            <tr>
                <td>{{ $pullout->order_number }}</td>
                <td>{{ $pullout->customer_details }}</td>
                <td>{{ $pullout->order_lists }}</td>
                <td>{{ $pullout->packaging_type }}</td>
                <td>{{ $pullout->sold_date }}</td>
                <td>{{ $pullout->remarks }}</td>
                <td>{{ $pullout->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>