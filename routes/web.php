<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\servicesController;
use App\Http\Controllers\ratecardsController;
use App\Http\Controllers\uploadsControllers;
use App\Http\Controllers\GemCardController;
use App\Http\Controllers\dimondCardController;

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
     Route::post('/updateConfirm-entry', [CustomerController::class, 'confirmEntryUpdate'])->name('confirmEntryUpdate');
     Route::get('/view-confirm-entry', [CustomerController::class, 'confirmEntryShow'])->name('confirmEntryShow');
     Route::get('/confirmEntrys', [CustomerController::class, 'confirmEntryShow'])->name('confirmEntrys.index');
     Route::get('/edit-confirm-entry/{id}', [CustomerController::class, 'confirmEntryEdit'])->name('confirmEntryEdit');
     Route::delete('/delete-item/{id}', [CustomerController::class, 'deleteItem']);
     Route::get('/updateConfirm-delete/{id}', [CustomerController::class, 'updateConfirmDelete'])->name('updateConfirmDelete');

    // services section
    Route::get('/list-services', [servicesController::class, 'list'])->name('servicesList');
    Route::post('/list-services/update', [servicesController::class, 'listserviceUpdate'])->name('listserviceUpdate');
    Route::post('/list-services/add', [servicesController::class, 'listserviceStore'])->name('listserviceStore');

    //ratecards
    Route::get('/list-rate-cards', [ratecardsController::class, 'list'])->name('rateCardList');
    Route::post('/list-rate-update', [ratecardsController::class, 'updateratecard'])->name('rateCardUpdate');

    // uploads for dimond jewellerys
    Route::get('/uploads', [uploadsControllers::class, 'index'])->name('uploadIndex');
  
    Route::post('/import', [uploadsControllers::class, 'import'])->name('import');
    Route::get('/download-file/{filename}', function ($filename) {
        $path = storage_path('app/public/uploads/' . $filename);
        //    dd($path );
        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404, 'File not found.');
        }
    })->name('download.file');
    Route::get('/dimond-job-card', [uploadsControllers::class, 'index'])->name('viewdiamondjob');
    Route::post('/dimond-job-card-update', [uploadsControllers::class, 'update_job_card'])->name('update_job_card');
    Route::get('/dimond-job-card-delete/{id}', [uploadsControllers::class, 'delete_job_card'])->name('delete_job_card');    
    Route::get('/print-certificates', [uploadsControllers::class, 'printCertificates'])->name('print_certificates');
    Route::get('/certificates/small', [uploadsControllers::class, 'generateSmallCertificates'])->name('certificates.small');
    Route::get('/certificates/large', [uploadsControllers::class, 'generateLargeCertificates'])->name('certificates.large');

     // uploads for GemCard Job
     Route::get('/uploadGemCard', [GemCardController::class, 'index'])->name('uploadGemCardIndex');
     Route::get('/gemCard-job-card-delete/{id}', [GemCardController::class, 'gemcard_job_card_delete'])->name('gemcard_job_card_delete'); 
     Route::post('/importGemsCard', [GemCardController::class, 'import'])->name('importGemsCard');
     Route::post('/gems-job-card-update', [GemCardController::class, 'update_gems_card'])->name('update_gems_card');
     Route::get('/print-gems-card-certificates', [GemCardController::class, 'printCertificates'])->name('print_gems_certificates');
        Route::get('/download-file-gems/{filename}', function ($filename) {
            $path = storage_path('app/public/uploads/' . $filename);
            //    dd($path );
            if (file_exists($path)) {
                return response()->download($path);
            } else {
                abort(404, 'File not found.');
            }
        })->name('gemsdownload.file');
     // upload Diamond Card Job
     Route::get('/upload-diamond-job-Card', [dimondCardController::class, 'index'])->name('diamondCardJobIndex');
     Route::post('/importDiamondCard', [dimondCardController::class, 'import'])->name('importDiamondCard');
     Route::get('/diamond-job-card-delete/{id}', [dimondCardController::class, 'diamond_job_card_delete'])->name('diamond_job_card_delete'); 
     Route::get('/print-gems-card-certificates', [dimondCardController::class, 'printCertificates'])->name('print_gems_certificates');
     Route::post('/diamond-job-card-update', [dimondCardController::class, 'update_diamond_card'])->name('update_diamond_card');
     Route::get('/print-diamond-card-certificates', [dimondCardController::class, 'printCertificates'])->name('print_diamond_certificates');
        Route::get('/download-file-diamond/{filename}', function ($filename) {
            $path = storage_path('app/public/uploads/' . $filename);
            //    dd($path );
            if (file_exists($path)) {
                return response()->download($path);
            } else {
                abort(404, 'File not found.');
            }
        })->name('dimonddownload.file');   
        
    // Gem Jewelery Card Upload
    Route::get('/upload-gem-jewelery-job-Card', [GemsJeweleryCardController::class, 'index'])->name('gemJeweleryCardJobIndex');
    Route::post('/importGemJeweleryCard', [GemsJeweleryCardController::class, 'import'])->name('importgemJeweleryCard');
    Route::get('/gem-jewelery-job-card-delete/{id}', [GemsJeweleryCardController::class, 'gem_jewelery_job_card_delete'])->name('gem_jewelery_job_card_delete'); 
    Route::get('/print-gem-jewelery-card-certificates', [GemsJeweleryCardController::class, 'printCertificates'])->name('print_gems_certificates');
    Route::post('/gem-jewelery-job-card-update', [GemsJeweleryCardController::class, 'update_gem_jewelery_card'])->name('update_gems_jewelery_card');
    Route::get('/print-gem-jewelery-card-certificates', [GemsJeweleryCardController::class, 'printCertificates'])->name('print_gems_jewelery_certificates');
       Route::get('/download-file-diamond/{filename}', function ($filename) {
           $path = storage_path('app/public/uploads/' . $filename);
           //    dd($path );
           if (file_exists($path)) {
               return response()->download($path);
           } else {
               abort(404, 'File not found.');
           }
       })->name('gemjewelery.download.file');      
    



     // Customer Required details
     Route::post('/get-cities', [CustomerController::class, 'getCities'])->name('get-cities');
     Route::get('/get-cities/{state_id}', [CustomerController::class, 'getCitiesData']);
     Route::post('/add_clientinformation', [CustomerController::class, 'add_clientinformation'])->name('add_clientinformation');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
