<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
     Route::get('/create-customer', [CustomerController::class, 'create'])->name('customer.add');
     Route::get('/view-customer', [CustomerController::class, 'viewClients'])->name('customer.viewClients');
     Route::get('/clients', [CustomerController::class, 'viewClients'])->name('clients.index');
    
     Route::get('/view-client-details/{id}', [CustomerController::class, 'viewClientById'])->name('clients.viewClientById');
     Route::get('/delete-client-details/{id}', [CustomerController::class, 'deleteClientById'])->name('clients.deleteClientById');
     Route::post('/client/update', [CustomerController::class, 'add_clientinformation'])->name('client.update');
    //  cobranding
     Route::get('/Co-branding/{id}', [CustomerController::class, 'cobranding_index'])->name('cobranding_index');
     Route::post('/Co-branding/store', [CustomerController::class, 'cobrandingStore'])->name('brandingStore');
     Route::post('/Co-branding/brandingupdate', [CustomerController::class, 'brandingupdate'])->name('brandingupdate');
     Route::get('/Co-branding-delete/{id}', [CustomerController::class, 'cobrandingDelete'])->name('cobrandingDelete');
     // Confirm Entry Form
     Route::get('/confirm-entry/{id}', [CustomerController::class, 'confirmEntryIndex'])->name('confirmEntryIndex');
     Route::post('/addConfirm-entry', [CustomerController::class, 'confirmEntryStore'])->name('confirmEntryStore');
     Route::get('/view-confirm-entry', [CustomerController::class, 'confirmEntryShow'])->name('confirmEntryShow');
     Route::get('/confirmEntrys', [CustomerController::class, 'confirmEntryShow'])->name('confirmEntrys.index');
     Route::get('/edit-confirm-entry/{id}', [CustomerController::class, 'confirmEntryEdit'])->name('confirmEntryEdit');

     Route::post('/get-cities', [CustomerController::class, 'getCities'])->name('get-cities');
     Route::get('/get-cities/{state_id}', [CustomerController::class, 'getCitiesData']);
     Route::post('/add_clientinformation', [CustomerController::class, 'add_clientinformation'])->name('add_clientinformation');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
