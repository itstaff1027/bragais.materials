// const videoElement = document.getElementById('camera-preview');
// const resultElement = document.getElementById('result');

// Quagga.init({
//     inputStream: {
//         name: "Live",
//         type: "LiveStream",
//         target: videoElement,
//         constraints: {
//             width: 640,
//             height: 480,
//         },
//     },
//     decoder: {
//         readers: ["ean_reader", "code_128_reader"],
//     },
// }, function(err) {
//     if (err) {
//         console.error(err);
//         return;
//     }
//     console.log("Initialization finished. Ready to start");
//     Quagga.start();
// });

// Quagga.onDetected(function(result) {
//     const code = result.codeResult.code;
//     resultElement.textContent = `Scanned barcode: ${code}`;
//     // Perform actions with the scanned barcode, such as making an API request, etc.
// });