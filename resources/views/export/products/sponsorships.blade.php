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
        @foreach ($sponsorships as $sponsorship)
            <tr>
                <td>{{ $sponsorship->order_number }}</td>
                <td>{{ $sponsorship->customer_details }}</td>
                <td>{{ $sponsorship->order_lists }}</td>
                <td>{{ $sponsorship->packaging_type }}</td>
                <td>{{ $sponsorship->sold_date }}</td>
                <td>{{ $sponsorship->remarks }}</td>
                <td>{{ $sponsorship->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>