<?php

use App\Livewire\Counter;
use App\Livewire\Products;
use App\Livewire\Dashboard;
use App\Livewire\Inventory;
use App\Livewire\Packaging;
use App\Livewire\ListOfUsers;
use App\Livewire\Products\Lara;
use App\Livewire\Products\LaraMonthly;
use App\Livewire\Products\Sold;
use App\Livewire\Packaging\PerDay;
use App\Livewire\Products\Barcode;
use App\Livewire\Products\OnStock;
use App\Exports\MaterialLogsExport;
use App\Livewire\Products\SalesLog;
use Illuminate\Support\Facades\Http;
use App\Livewire\Packaging\AddStocks;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\DeliveryLog;
use App\Livewire\Products\ProductLogs;
use App\Livewire\Technical\CreateUser;
use App\Http\Controllers\PDFController;
use App\Livewire\Technical\CreateRoles;
use App\Livewire\Packaging\DeductStocks;
use App\Livewire\Packaging\MaterialLogs;
use App\Livewire\Products\ProductSummary;
use App\Livewire\Products\GenerateBarcode;
use App\Http\Controllers\ProfileController;
use App\Livewire\Products\MonthlyDelivered;
use App\Livewire\Products\OutgoingProducts;
use App\Livewire\Products\CompletePackaging;
use App\Livewire\Factory\AddTodo as FactAddTodo;
use App\Livewire\Factory\Details as FactDetails;
use App\Livewire\Inventory\AddTodo as InvAddTodo;
use App\Livewire\Inventory\Details as InvDetails;
use App\Livewire\Products\NewModel as NewProduct;
use App\Livewire\Factory\NewModel as FactNewModel;
use App\Livewire\Factory\Progress as FactProgress;
use App\Livewire\Packaging\Components\GeneratePdf;
use App\Livewire\Inventory\NewModel as InvNewModel;
use App\Livewire\Inventory\Progress as InvProgress;
use App\Livewire\Products\Details as ProductDetails;
use App\Livewire\Components\Products\AddStockBarcode;
use App\Livewire\Inventory\Summary as summaryOutgoing;
use App\Livewire\Packaging\Summary as summaryPackaging;
use App\Livewire\Products\Summary as summaryOutgoingProducts;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/counter', Counter::class);

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/inventory', Inventory::class)->name('inventory');

    Route::get('/inventory/product_progress', InvProgress::class)->name('product-development-progress');

    Route::get('/inventory/material-details/{id}', InvDetails::class)->name('update-material-details');

    Route::get('/inventory/add-new_material', InvNewModel::class)->name('add-new-material');

    Route::get('/inventory/add-todo', InvAddTodo::class)->name('add_to-do');

});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/products', Products::class)->name('products');

    Route::get('/products/add_new-model', NewProduct::class)->name('product_add-model');

    Route::get('/products/complete_packaging/{id}', CompletePackaging::class)->name('complete-packaging');
    Route::get('/products/add-outgoing_products/{id}', OutgoingProducts::class)->name('outgoing-products');

    Route::get('/products/product-logs', ProductLogs::class)->name('product-logs');

    Route::get('/products/outgoing/summary', summaryOutgoingProducts::class)->name('summary-outgoing');
    Route::get('/products/monthly-outgoing/summary', MonthlyDelivered::class)->name('monthly-summary-outgoing');

    Route::get('/products/sold/per_day', Sold::class)->name('products.sold_per_day');

    Route::get('/products/details/{id}', ProductDetails::class)->name('update-product');

    Route::get('/products/generate-barcode/{id}', GenerateBarcode::class)->name('generate-barcode-product');

    Route::get('/products/list-barcodes', Barcode::class)->name('list-barcodes');

    Route::get('/products/sales-log', SalesLog::class)->name('sales-logs');

    Route::post('/api/add-barcode', [AddStockBarcode::class, 'handleBarcode']);

    Route::get('/products/delivery-logs', DeliveryLog::class)->name('delivery-logs');

    Route::get('/products/product_stocks-summary', ProductSummary::class)->name('products.summary_stocks');

    Route::get('/products/lara', Lara::class)->name('products.lara');
    Route::get('/products/lara-monthly', LaraMonthly::class)->name('lara-monthly');


});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/packaging', Packaging::class)->name('packaging');

    Route::get('/packaging/add-stocks/{id}', AddStocks::class)->name('add-packaging-materials');
    Route::get('/packaging/deduct-stocks/{id}', DeductStocks::class)->name('deduct-packaging-materials');

    Route::get('/packaging/per-day', PerDay::class)->name('packaging-per-day');
    Route::get('/packaging/material-logs', MaterialLogs::class)->name('material-logs');
    Route::get('/packaging/summary', summaryPackaging::class)->name('summary-materials');
    // Route::get('/packaging/materials/export/', [summaryPackaging::class, 'export'])->name('export-material');

    Route::get('/packaging/per-day/generate_pdf_today_report', GeneratePdf::class)->name('generate-pdf');
    Route::get('/generate-pdf', [GeneratePdf::class, 'render']);

});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/factory', function () {
        return view('factory');
    })->name('factory');

    Route::get('/factory/to-receive', FactAddTodo::class)->name('to-receive_materials');

    Route::get('/factory/product_progress', FactProgress::class)->name('factory-product-development-progress');

    Route::get('/factory/material-details/{id}', FactDetails::class)->name('factory-update-material-details');

    Route::get('/factory/add-new_material', FactNewModel::class)->name('factory-add-new-material');

    Route::get('/factory/add-todo', FactAddTodo::class)->name('factory-add_to-do');


});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/users', ListOfUsers::class)->name('users');

    Route::get('/create-user', CreateUser::class)->name('create-user');
    Route::get('/create-roles', CreateRoles::class)->name('create-roles');
});

// Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
