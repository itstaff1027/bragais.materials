<?php

use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

    // Route::get('/inventory/add-stocks/{id}', AddStocks::class)->name('add-stocks');

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
