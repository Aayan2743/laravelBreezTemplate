<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cuttables;
use App\Models\gemstonejobcardtabs;
use App\Models\cjobcardtables;
use App\Imports\UploadBulkGems;
use App\Imports\uploadBulkGemsStoneJewellery;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class GemsJeweleryCardController extends Controller
{
    
    public function index(Request $request){

        $query = cjobcardtables::orderBy('jobcard_id', 'desc');

        if ($request->has('search')) {
            $query->where('confirmid', 'like', '%' . $request->search . '%');
                
        }
    
        $clientinformation = $query->paginate(8);

        // dd($clientinformation);
    
        if ($request->ajax()) {
            return view('partials.client_table_gems_jewelery_card', compact('clientinformation'))->render();
        }
    
        return view('uploadgemJeweleryCardJob', compact('clientinformation'));
        // return view('uploads');
    }

    public function import(Request $request){

        // dd($request->all());

        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ]);

        Excel::import(new uploadBulkGemsStoneJewellery, $request->file('file'));

        return back()->with('success', 'Excel file imported successfully!');
    }


    public function gem_jewelery_job_card_delete($id){
        //dd($id);
        $jobcardtables=cjobcardtables::where('jobcard_id',$id)->delete();
       

        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Confirmation  Entry deleted successfully!');
        // dd($clientinformation);
    }

    public function update_gem_jewelery_card(Request $request){




     //dd($request->all());
    
        $jobCard = cjobcardtables::where('jobcard_id', $request->jobcard_id)->first();
    
        if (!$jobCard) {
            return back()->with('error', 'Job Card not found.');
        }
    
        // Check if a new image is uploaded
        if ($request->hasFile('imagePrev')) {

            // dd("fjgdfjg");
            // Delete old image if it exists
            if ($jobCard->image && Storage::exists('public/uploads/' . $jobCard->image)) {
                Storage::delete('public/uploads/' . $jobCard->image);
            }
    
            // Store new image
            $imageName = time() . '.' . $request->imagePrev->extension();

          
            $request->imagePrev->storeAs('public/uploads', $imageName); // Save in storage/app/public/uploads
            $jobCard->image = $imageName;
        }
    
        // Update other fields
        $updateData = [
            'service' => $request->service,
            'item' => $request->item,
            'grwt' => $request->grwt,
            'estwt' => $request->estwt,
            'metal' => $request->metal,
            'cut' => $request->cut,
            'conc' => $request->conc,
            'conc1' => $request->conc1,
            'nol' => $request->nol,
            // 'refindex' => $request->claritySelect,
            // 'comments' => $request->colorSelect,
           
        ];
    
        if (isset($imageName)) {
            $updateData['image'] = $imageName;
        }
    
        $updateJobCard = $jobCard->update($updateData);
    
        // dd($updateJobCard);
        if ($updateJobCard) {
            return back()->with('success', 'Updated Successfully');
        } else {
            return back()->with('error', 'Something went wrong, please try again later');
        }
      

    }

    public function printCertificates(Request $request)
    {
       
        $jobcardIds = explode(',', $request->query('ids'));

      

    $jobCards = cjobcardtables::whereIn('jobcard_id', $jobcardIds)
    ->with(['cutss','metalss','itemss']) // Load related data
    ->get();
       // dd($jobCards);

    $url = url('/print-gem-jewelery-card-certificates?ids=on,' . implode(',', $jobcardIds));
   

    $qrCode = QrCode::size(200)->generate($url);

   
        $pdf = PDF::loadView('gems_jewellery_certificate_template', compact('jobCards','qrCode'));

        // Return PDF as download or open in browser
        return $pdf->stream('gems_jewellery_certificate.pdf');
    }
  



}
