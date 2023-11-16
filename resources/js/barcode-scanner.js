import Quagga from 'quagga';

let scanning = true;
let scannedBarcode = '';


document.addEventListener('livewire:init', () => {
    startBarcodeScanner();  
    function startBarcodeScanner() {
        Quagga.init({
            inputStream: {
                name: 'Live',
                type: 'LiveStream',
                target: document.querySelector('#barcode-scanner'),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: 'environment', // Use the rear camera (change to 'user' for front camera)
                },
            },
            locator: {
                patchSize: 'medium',
                halfSample: true,
            },
            numOfWorkers: 2,
            decoder: {
                readers: ['code_128_reader'],
            },
            locate: true,
        }, function (err) {
            if (err) {
                console.error(err);
                return;
            }
    
            // Set the willReadFrequently attribute to true
            let canvas = document.createElement('canvas');
            canvas.willReadFrequently = true;
    
            Quagga.start();
    
            Quagga.onDetected(function (result) {
                if (scanning) {
                    try {
                        console.log(result.codeResult.code);
    
                        scannedBarcode = result.codeResult.code;

                        
                        Livewire.dispatch('handleBarcode', { scannedBarcode: result.codeResult.code });
                        scanning = false; // Pause scanning
                        setTimeout(function() {
                            // Livewire.dispatch('clearMessage');
                            scanning = true; // Resume scanning after 2 seconds
                            Quagga.stop();
                            startBarcodeScanner(); 
                            
                        }, 2500); // 3000 milliseconds = 3 seconds
                        
                    } catch (err) {
                        console.log(err);
                    }
                }
            });
        });
    }
});
//     function sendBarcodeToServer(barcode) {
//         // barcode = barcode.replace(/^.*?(\d{1,}-\d{8}-\d{2})$/, '$1');
//         fetch('/api/add-barcode', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({
//                 barcode: barcode
//             })
//         })
//         .then(response => response.json())
//         .then(data => {
//             // Handle the response from the server if needed
//             console.log(data);
//         })
//         .catch(error => {
//             // Handle errors
//             console.error(error);
//         });
//     }
// })
