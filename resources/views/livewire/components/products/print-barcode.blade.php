<div class="flex-col m-3 justify-center items-center print-section hidden">
    @foreach ($barcodesPrint as $barcode)
    <div style="margin: 20px;">
        <div class="m-3" style="text-align: center;">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG("$barcode->barcode_id-$barcode->barcode", 'C128') }}" alt="Barcode">
        </div>
        <div style="text-align: center;">
            <span>{{ $barcode->barcode_id }}-{{ $barcode->barcode }}-{{ $barcode->model }}-{{ $barcode->color }}-{{ $barcode->size }}-{{ $barcode->heel_height }}</span>
        </div>
    </div>
    @endforeach
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            var printWindow = window.open('', '', 'width=1000,height=800');
            printWindow.document.write('<html><head><title>Print</title></head><body>');
            printWindow.document.write('<div class="print-section">');
            printWindow.document.write(document.querySelector('.print-section').innerHTML);
            printWindow.document.write('</div></body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    </script>
</div>