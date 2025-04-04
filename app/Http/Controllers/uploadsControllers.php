<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Imports\UploadsBulk;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\cuttables;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class uploadsControllers extends Controller
{
    //
    public function printCertificates(Request $request)
    {
        $jobcardIds = explode(',', $request->query('ids'));
    $jobCards = jobcardtables::whereIn('jobcard_id', $jobcardIds)
    ->with(['metalss', 'clarityss', 'colorss', 'cutss']) // Load related data
    ->get();
    $url = url('/print-certificates?ids=on,' . implode(',', $jobcardIds));
    $qrCode = QrCode::size(200)->generate($url);
        $pdf = PDF::loadView('certificate_template', compact('jobCards','qrCode'));
        // Return PDF as download or open in browser
        return $pdf->stream('certificates.pdf');
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
                    jobcardtables::where('jobcard_id', $jobcard_id)->update([
                        'image' => $filename
                    ]);
                    $uploadedImages[] = $filename;
                }
            }
            return back()->with('success', 'Images uploaded successfully!');
        }
    public function index(Request $request){
        $query = jobcardtables::orderBy('jobcard_id', 'desc');
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('confirmid', 'like', '%' . $request->search . '%')
                  ->orWhere('jobcardid', 'like', '%' . $request->search . '%');
            });
        }
        $clientinformation = $query->paginate(8);
        // dd($clientinformation);
        if ($request->ajax()) {
            return view('partials.client_table_jobcard', compact('clientinformation'))->render();
        }
        return view('uploads', compact('clientinformation'));
        // return view('uploads');
    }
    public function delete_job_card($id){
        //dd($id);
        $jobcardtables=jobcardtables::where('jobcard_id',$id)->delete();
        // $clientinformation->delete();
        return redirect()->back()->with('success', 'Confirmation  Entry deleted successfully!');
        // dd($clientinformation);
    }
    public function update_job_card(Request $request){
        // dd($request->all());
        $jobCard = Jobcardtables::where('jobcard_id', $request->uid)->first();
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
            'confirmid' => $request->confno,
            'service' => $request->serviceSelect,
            'item' => $request->itemSelect,
            'grwt' => $request->gwt,
            'estwt' => $request->estet,
            'metal' => $request->metalSelect,
            'calrity' => $request->claritySelect,
            'color' => $request->colorSelect,
            'cut' => $request->cutSelect,
            'big_j' => $request->bigSelect,
            'nol' => $request->nol,
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
        //  dd($request->all());
        //  if ($request->hasFile('imagePrev')) {
        //     // Delete old image if it exists
        //     if ($jobCard->nol && Storage::exists('public/uploads/' . $jobCard->nol)) {
        //         Storage::delete('public/uploads/' . $jobCard->nol);
        //     }
        //     // Store new image
        //     $imageName = time() . '.' . $request->nol->extension();
        //     $request->nol->storeAs('public/uploads', $imageName); // Save in storage/app/public/uploads
        //     $jobCard->nol = $imageName;
        // }
        // $updateJob_card=jobcardtables::where('jobcard_id',$request->uid)->update([
        //     'confirmid'=>$request->confno,
        //     'service'=>$request->serviceSelect,
        //     // 'dia'=>$request->uid,
        //     // 'rate'=>$request->uid,
        //     'item'=>$request->itemSelect,
        //     'grwt'=>$request->gwt,
        //     'estwt'=>$request->estet,
        //     'metal'=>$request->metalSelect,
        //     'calrity'=>$request->claritySelect,
        //     'color'=>$request->colorSelect,
        //     'cut'=>$request->cutSelect,
        //     'nol'=>$request->nol,
        //     'big_j'=>$request->bigSelect,
        // ]);
        // // dd($updateJob_card);
        // if($updateJob_card){
        //     return back()->with('success', 'Updated Successfully');
        // }else{
        //     return back()->with('error', 'Somthing went wrong please try again later');
        // } 
    }
    public function import(Request $request){
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ]);
        Excel::import(new UploadsBulk, $request->file('file'));
        return back()->with('success', 'Excel file imported successfully!');
    }
    public function viewDiamondJewellery (Request $request){
        $query = jobcardtables::orderBy('jobcard_id', 'desc');
        if ($request->has('search')) {
            $query->where('confirmid', 'like', '%' . $request->search . '%');
        }
        $clientinformation = $query->paginate(8);
        dd($clientinformation);
        if ($request->ajax()) {
            return view('partials.client_table_jobcard', compact('clientinformation'))->render();
        }
        return view('uploads', compact('clientinformation'));
    }
}