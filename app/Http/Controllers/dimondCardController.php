<?php

namespace App\Http\Controllers;


use App\Models\cuttables;
use App\Models\gemstonejobcardtabs;
use App\Models\djobcardtables;
use Illuminate\Http\Request;
use App\Imports\UploadBulkGems;
use App\Imports\dimondCardJob;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class dimondCardController extends Controller
{
    //

    public function index(Request $request){

        $query = djobcardtables::orderBy('djobcard_id', 'desc');

        // if ($request->has('search')) {
        //     $query->where('confirmid', 'like', '%' . $request->search . '%');
                
        // }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('confirmid', 'like', '%' . $request->search . '%')
                  ->orWhere('djobcardid', 'like', '%' . $request->search . '%');
            });
        }
    
        $clientinformation = $query->paginate(8);

        // dd($clientinformation);
    
        if ($request->ajax()) {
            return view('partials.client_table_diamondCard', compact('clientinformation'))->render();
        }
    
        return view('uploadDiamondCardJob', compact('clientinformation'));
        // return view('uploads');
    }

    public function diamond_job_card_delete($id){
        //dd($id);
        $jobcardtables=djobcardtables::where('djobcard_id',$id)->delete();
       

        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Confirmation  Entry deleted successfully!');
        // dd($clientinformation);
    }

    public function printCertificates(Request $request)
    {
       
        $jobcardIds = explode(',', $request->query('ids'));

      

    // $jobCards = djobcardtables::whereIn('djobcard_id', $jobcardIds)
    // ->with(['cutss']) // Load related data
    // ->get();

    
    $jobCards = djobcardtables::whereIn('djobcard_id', $jobcardIds)
    ->with(['metalss', 'clarityss', 'colorss', 'cutss']) // Load related data
    ->get();

      

    $url = url('/print-diamond-card-certificates?ids=on,' . implode(',', $jobcardIds));
   

    $qrCode = QrCode::size(200)->generate($url);

   
        $pdf = PDF::loadView('daimond_certificate_template', compact('jobCards','qrCode'));

        // Return PDF as download or open in browser
        return $pdf->stream('gems_certificates.pdf');
    }

    public function import(Request $request){

      

        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ]);

        Excel::import(new dimondCardJob, $request->file('file'));

        return back()->with('success', 'Excel file imported successfully!');
    }

    public function uploadImages(Request $request)
    {
        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $jobcard_id => $file) {
                // Generate unique name
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');

                // Update database
                djobcardtables::where('djobcard_id', $jobcard_id)->update([
                    'image' => $filename
                ]);

                $uploadedImages[] = $filename;
            }
        }

        return back()->with('success', 'Images uploaded successfully!');
    }


    public function update_diamond_card(Request $request){




        // dd($request->all());
    
        $jobCard = djobcardtables::where('djobcard_id', $request->djobcard_id1)->first();
        // dd($jobCard);
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
            'nop' => $request->nop,
            'cut' => $request->cut,
            'carat' => $request->carat,
            'measure' => $request->measure,
            'clarity' => $request->clarity,
            'color' => $request->color,
            'florosense' => $request->florosense,
            'finish' => $request->finish,
            'crown' => $request->crown,
            'tble' => $request->tble,
            'pavilion' => $request->pavilion,
            'culet' => $request->culet,
            'girdle' => $request->girdle,
            'big_d' => $request->big_d,
           
           
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


}
