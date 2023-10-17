<?php

use App\Exports\MaterialLogsExport;
use App\Livewire\Counter;
use App\Livewire\Packaging\PerDay;
use App\Livewire\Inventory\Details;
use App\Livewire\Packaging\AddStocks;
use App\Livewire\Packaging\Summary;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Livewire\Packaging\DeductStocks;
use App\Http\Controllers\ProfileController;
use App\Livewire\Products\CompletePackaging;
use App\Livewire\Packaging\Components\GeneratePdf;
use App\Livewire\Packaging\MaterialLogs;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/inventory', function () {
        return view('inventory');
    })->name('inventory');

    Route::get('/inventory/material-details/{id}', Details::class)->name('material-details');

    // Route::get('/inventory/add-outlet_stocks/{id}', AddOutletStocks::class)->name('add-outlet_stocks');

    // Route::get('/inventory/add-display_stocks/{id}', AddDisplayStocks::class)->name('add-display_stocks');

    // Route::get('/inventory/edit-model/{id}', EditModel::class)->name('edit-model');

    // Route::get('/inventory/add-new-model', AddNewModel::class)->name('add-new-model');

    // Route::get('/inventory/stocks', Stocks::class)->name('stocks');

    // Route::get('/inventory/display', Display::class)->name('display');

    // Route::get('/inventory/outlet', Outlet::class)->name('outlet');

    // Route::get('/inventory/displays', Displays::class)->name('displays');

    // Route::get('/inventory/outlets', Outlets::class)->name('outlets');

    // Route::get('/inventory/new_model', NewModel::class)->name('new_model');
});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/products', function () {
        return view('products');
    })->name('products');

    Route::get('/products/complete_packaging/{id}', CompletePackaging::class)->name('complete-packaging');
});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/packaging', function () {
        return view('packaging_materials');
    })->name('packaging');

    Route::get('/packaging/add-stocks/{id}', AddStocks::class)->name('add-packaging-materials');
    Route::get('/packaging/deduct-stocks/{id}', DeductStocks::class)->name('deduct-packaging-materials');

    Route::get('/packaging/per-day', PerDay::class)->name('packaging-per-day');
    Route::get('/packaging/material-logs', MaterialLogs::class)->name('material-logs');
    Route::get('/packaging/summary', Summary::class)->name('summary');

    Route::get('/packaging/per-day/generate_pdf_today_report', GeneratePdf::class)->name('generate-pdf');
    Route::get('/generate-pdf', [GeneratePdf::class, 'render']);

    Route::get('materials/export/', [Summary::class, 'export'])->name('export');
});

// Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
