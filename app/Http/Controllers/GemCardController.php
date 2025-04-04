<?php
namespace App\Http\Controllers;
use App\Models\cuttables;
use App\Models\gemstonejobcardtabs;
use Illuminate\Http\Request;
use App\Imports\UploadBulkGems;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
class GemCardController extends Controller
{
    //
    public function index(Request $request){
        $query = gemstonejobcardtabs::orderBy('gjobcard_id', 'desc');
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('confirmid', 'like', '%' . $request->search . '%')
                  ->orWhere('gjobcardid', 'like', '%' . $request->search . '%');
            });
        }
        //gjobcardid
        $clientinformation = $query->paginate(8);
        // dd($clientinformation);
        if ($request->ajax()) {
            return view('partials.client_table_gemsCard', compact('clientinformation'))->render();
        }
        return view('uploadsgemCards', compact('clientinformation'));
        // return view('uploads');
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
                gemstonejobcardtabs::where('gjobcard_id', $jobcard_id)->update([
                    'image' => $filename
                ]);
                $uploadedImages[] = $filename;
            }
        }
        return back()->with('success', 'Images uploaded successfully!');
    }
    public function import(Request $request){
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ]);
        Excel::import(new UploadBulkGems, $request->file('file'));
        return back()->with('success', 'Excel file imported successfully!');
    }
    public function gemcard_job_card_delete($id){
        //dd($id);
        $jobcardtables=gemstonejobcardtabs::where('gjobcard_id',$id)->delete();
        // $clientinformation->delete();
        return redirect()->back()->with('success', 'Confirmation  Entry deleted successfully!');
        // dd($clientinformation);
    }
    public function update_gems_card(Request $request){
        // dd($request->all());
        $jobCard = gemstonejobcardtabs::where('gjobcard_id', $request->uid)->first();
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
            'species' => $request->species,
            'variety' => $request->variety,
            'shape' => $request->shape,
            'carat' => $request->carat,
            'measure' => $request->measure,
            'transperancy' => $request->transperancy,
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
    $jobCards = gemstonejobcardtabs::whereIn('gjobcard_id', $jobcardIds)
    ->with(['cutss']) // Load related data
    ->get();
    $url = url('/print-gems-card-certificates?ids=on,' . implode(',', $jobcardIds));
    $qrCode = QrCode::size(200)->generate($url);
        $pdf = PDF::loadView('gems_certificate_template', compact('jobCards','qrCode'));
        // Return PDF as download or open in browser
        return $pdf->stream('gems_certificates.pdf');
    }
}
