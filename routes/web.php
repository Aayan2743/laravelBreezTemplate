<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\servicesController;
use App\Http\Controllers\ratecardsController;
use App\Http\Controllers\uploadsControllers;
use App\Http\Controllers\GemCardController;
use App\Http\Controllers\dimondCardController;
use App\Http\Controllers\GemsJeweleryCardController;
use App\Http\Controllers\UncutJewelleryJobCardController;
use App\Http\Controllers\settings;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\Cuttable;
use App\Http\Controllers\MetalController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\userprofileController;
use App\Http\Controllers\ConfirmPrint;
use App\Http\Controllers\extrainvoiceChargesController;

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
    return view('certificate_user');
});

Route::get('/dashboard', function () {
    return view('dashboard');
    // Route::get('/create-customer', [CustomerController::class, 'create'])->name('customer.add');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
     Route::get('/create-customer', [CustomerController::class, 'create'])->name('customer.add');
     Route::get('/view-customer', [CustomerController::class, 'viewClients'])->name('customer.viewClients');
     Route::get('/clients', [CustomerController::class, 'viewClients'])->name('clients.index');
    
     Route::get('/view-client-details/{id}', [CustomerController::class, 'viewClientById'])->name('clients.viewClientById');
     Route::get('/delete-client-details/{id}', [CustomerController::class, 'deleteClientById'])->name('clients.deleteClientById');
    //  Route::post('/client/update', [CustomerController::class, 'add_clientinformation'])->name('client.update');
     Route::post('/client/update/{id}', [CustomerController::class, 'update_client_information'])->name('client.update');
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


    // Billing Section
    // Route::get('/invoices', [BillingController::class, 'confirmEntryShow'])->name('confirmEntryShow');
    Route::resource('invoices', BillingController::class); 
    Route::get('getReport/{id}', [BillingController::class,'getReport'])->name('getReport.id'); 
    Route::get('getReportWithLogo/{id}', [BillingController::class,'getReportWithLogo'])->name('getReport.id.logo'); 
    Route::get('cashMemo/{id}', [BillingController::class,'CashMemo'])->name('getReport.cashmemo'); 

    // services section
    Route::get('/list-services', [servicesController::class, 'list'])->name('servicesList');
    Route::post('/list-services/update', [servicesController::class, 'listserviceUpdate'])->name('listserviceUpdate');
    Route::post('/list-services/add', [servicesController::class, 'listserviceStore'])->name('listserviceStore');


    // extra invoice charges
    Route::get('/list-invoice-charges/{id}', [extrainvoiceChargesController::class, 'index'])->name('extrainvoiceCharges');
    Route::post('/add-invoice-charges', [extrainvoiceChargesController::class, 'store'])->name('addExtraAmount');
    Route::post('/update-invoice-charges', [extrainvoiceChargesController::class, 'update'])->name('updateExtraAmount');
    Route::get('/delete-invoice-charges/{id}', [extrainvoiceChargesController::class, 'delete'])->name('deleteExtraAmount'); 

    //settings
    //ratecards
    Route::get('/list-rate-cards', [ratecardsController::class, 'list'])->name('rateCardList');
    Route::post('/list-rate-update', [ratecardsController::class, 'updateratecard'])->name('rateCardUpdate');
    // clarity
    Route::get('/clarity', [settings::class, 'clarityindex'])->name('clarity.index');
    Route::post('/clarity/update', [settings::class, 'clarity_update'])->name('clarity.update');
    Route::post('/clarity/store', [settings::class, 'store_clarity'])->name('store_clarity');
    Route::get('/clarity/delete/{id}', [settings::class, 'clarity_delete'])->name('clarity_delete'); 
      // Items
      Route::get('/Items', [ItemController::class, 'itemIndex'])->name('item.index');
      Route::post('/item/update', [ItemController::class, 'item_update'])->name('items.update');
      Route::post('/item/store', [ItemController::class, 'store_item'])->name('store_item');
      Route::get('/item/delete/{id}', [ItemController::class, 'item_delete'])->name('item_delete'); 
       // for color 
      Route::resource('color', ColorController::class); 
      Route::post('/color/update', [ColorController::class, 'updateDetails'])->name('color.updateDetails');
         // for cuttable 
         Route::resource('cut', Cuttable::class); 
         Route::post('/cut/update', [Cuttable::class, 'updateDetails'])->name('cut.updateDetails');  

        // for metals 
        Route::resource('metals', MetalController::class); 
        Route::post('/metals/update', [MetalController::class, 'updateDetails'])->name('metals.updateDetails');    

        Route::resource('/user-profile', userprofileController::class);
        Route::put('/profile/update/{user}', [userprofileController::class, 'updateUpdate'])->name('updateUpdate');

    // uploads for dimond jewellerys
    Route::get('/uploads', [uploadsControllers::class, 'index'])->name('uploadIndex');
    Route::post('/upload-images', [uploadsControllers::class, 'uploadImages'])->name('upload_images');
  
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
     Route::post('/upload-images-gems', [GemCardController::class, 'uploadImages'])->name('upload_gem_images');
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
     Route::post('/upload-images-diamond', [dimondCardController::class, 'uploadImages'])->name('upload_diamond_images');
     Route::post('/importDiamondCard', [dimondCardController::class, 'import'])->name('importDiamondCard');
     Route::get('/diamond-job-card-delete/{id}', [dimondCardController::class, 'diamond_job_card_delete'])->name('diamond_job_card_delete'); 
    //  Route::get('/print-diamond-card-certificates', [dimondCardController::class, 'printCertificates'])->name('print_diamond_certificates');
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
        })->name('dimonddownloads.download.file');   
        
    // Gem Jewelery Card Upload
    Route::get('/upload-gem-jewelery-job-Card', [GemsJeweleryCardController::class, 'index'])->name('gemJeweleryCardJobIndex');
    Route::post('/upload-images-gem_jewellery', [GemsJeweleryCardController::class, 'uploadImages'])->name('upload_gem_jewelery_images');
    Route::post('/importGemJeweleryCard', [GemsJeweleryCardController::class, 'import'])->name('importgemJeweleryCard');
    Route::get('/gem-jewelery-job-card-delete/{id}', [GemsJeweleryCardController::class, 'gem_jewelery_job_card_delete'])->name('gem_jewelery_job_card_delete'); 
    // Route::get('/print-gem-jewelery-card-certificates', [GemsJeweleryCardController::class, 'printCertificates'])->name('print_gems_certificates');
    Route::post('/gem-jewelery-job-card-update', [GemsJeweleryCardController::class, 'update_gem_jewelery_card'])->name('update_gems_jewelery_card');
    Route::get('/print-gem-jewelery-card-certificates', [GemsJeweleryCardController::class, 'printCertificates'])->name('print_gems_jewelery_certificates');
     
    Route::get('/download-file-diamondss/{filename}', function ($filename) {
           $path = storage_path('app/public/uploads/' . $filename);
           //    dd($path );
           if (file_exists($path)) {
               return response()->download($path);
           } else {
               abort(404, 'File not found.');
           }
       })->name('gemjewelery.download.files');      
    
        // Uncut Jewellery Job Card
       Route::get('/upload-uncut-jewelery-job-Card', [UncutJewelleryJobCardController::class, 'index'])->name('uncutjewelleryIndex');
       Route::post('/upload-images-uncut-jewellery', [UncutJewelleryJobCardController::class, 'uploadImages'])->name('upload_uncut_jewelery_images');
       Route::post('/importUncutJeweleryCard', [UncutJewelleryJobCardController::class, 'import'])->name('importUnCutJeweleryCard');
       Route::get('/uncut-jewelery-job-card-delete/{id}', [UncutJewelleryJobCardController::class, 'uncut_jewelery_job_card_delete'])->name('uncut_jewelery_job_card_delete'); 
       Route::post('/uncut-jewelery-job-card-update', [UncutJewelleryJobCardController::class, 'update_uncut_jewelery_card'])->name('update_uncut_jewelery_card');
       Route::get('/print-uncut-jewelery-card-certificates', [UncutJewelleryJobCardController::class, 'printCertificates'])->name('print_uncut_jewelery_certificates');
          Route::get('/download-file-diamonds/{filename}', function ($filename) {
              $path = storage_path('app/public/uploads/' . $filename);
              //    dd($path );
              if (file_exists($path)) {
                  return response()->download($path);
              } else {
                  abort(404, 'File not found.');
              }
          })->name('uncutjewellery.download.file');      
          
    
    // confirmation Entry Print
    Route::get('/print-confirm/{conid}',[ConfirmPrint::class,'printCertificates'])->name('print.confirmation');      




     // Customer Required details
     Route::post('/get-cities', [CustomerController::class, 'getCities'])->name('get-cities');
     Route::get('/get-cities/{state_id}', [CustomerController::class, 'getCitiesData']);
     Route::post('/add_clientinformation', [CustomerController::class, 'add_clientinformation'])->name('add_clientinformation');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
