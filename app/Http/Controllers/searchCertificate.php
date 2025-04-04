<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\djobcardtables;
use App\Models\gemstonejobcardtabs;
use App\Models\cjobcardtables;
use App\Models\uncutcardtables;
use App\Models\jobcardtables;
use App\Models\jobid;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class searchCertificate extends Controller
{
    //
    public function index(){
        return view('certificate_user');
    }
    public function search(Request $req){
         $get_jobid=jobid::where('jobid',$req->jobid)->get();
        // dd($get_jobid);
        if(count($get_jobid)>0){
            $get_model=$get_jobid[0]->model;
            // dd($get_model);
            switch ($get_model) {
                case "djobcardtables":
                    $full_model_class = "App\\Models\\" . $get_model;
                    if (class_exists($full_model_class)) {
                        $get_certificate = $full_model_class::get();
                        $jobCards = djobcardtables::where('djobcard_id', $get_certificate[0]->djobcard_id)
                            ->with(['metalss', 'clarityss', 'colorss', 'cutss']) // Load related data
                            ->get();
                        $url = url('/print-diamond-card-certificates?ids=on,' .$get_certificate[0]->djobcard_id );
                        $qrCode = QrCode::size(200)->generate($url);
                        $pdf = PDF::loadView('daimond_certificate_template', compact('jobCards', 'qrCode'));
                        return $pdf->stream('gems_certificates.pdf');
                    } else {
                        $get_certificate = collect(); // Return empty collection if model doesn't exist
                    }
                    break;
                case "gemstonejobcardtabs":
                    $full_model_class = "App\\Models\\" . $get_model;
                    if (class_exists($full_model_class)) {
                        $get_certificate = $full_model_class::get();
                        $jobCards = gemstonejobcardtabs::where('gjobcard_id', $get_certificate[0]->gjobcard_id)
                        ->with(['cutss']) // Load related data
                        ->get();
                        $url = url('/print-gems-card-certificates?ids=on,' . $get_certificate[0]->gjobcard_id);
                        $qrCode = QrCode::size(200)->generate($url);
                            $pdf = PDF::loadView('gems_certificate_template', compact('jobCards','qrCode'));
                            // Return PDF as download or open in browser
                            return $pdf->stream('gems_certificates.pdf');
                    }
                case "cjobcardtables":
                    $full_model_class = "App\\Models\\" . $get_model;
                    if (class_exists($full_model_class)) {
                        $get_certificate = $full_model_class::get();
                        $jobCards = cjobcardtables::where('jobcard_id', $get_certificate[0]->jobcard_id)
                    ->with(['cutss','metalss','itemss']) // Load related data
                    ->get();
                       // dd($jobCards);
                    $url = url('/print-gem-jewelery-card-certificates?ids=on,' . $get_certificate[0]->jobcard_id);
                    $qrCode = QrCode::size(200)->generate($url);
                        $pdf = PDF::loadView('gems_jewellery_certificate_template', compact('jobCards','qrCode'));
                        // Return PDF as download or open in browser
                        return $pdf->stream('gems_jewellery_certificate.pdf');
                    }
                    break;
                case "uncutcardtables":
                    $full_model_class = "App\\Models\\" . $get_model;
                    if (class_exists($full_model_class)) {
                        $get_certificate = $full_model_class::get();
                        $jobCards = uncutcardtables::where('jobcard_id', $get_certificate[0]->jobcard_id)
                        ->with(['cutss','metalss','itemss','clarityss','colorss']) // Load related data
                        ->get();
                          //  dd($jobCards);
                        $url = url('/print-uncut-jewelery-card-certificates?ids=on,' . $get_certificate[0]->jobcard_id);
                        $qrCode = QrCode::size(200)->generate($url);
                            $pdf = PDF::loadView('uncut_jewellery_certificate_template', compact('jobCards','qrCode'));
                            // Return PDF as download or open in browser
                            return $pdf->stream('uncut_jewellery_certificate.pdf');
                    }
                        echo "Today is uncutcardtables.";
                    break;
                case "jobcardtables":
                    $full_model_class = "App\\Models\\" . $get_model;
                    $get_certificate = $full_model_class::get();
                    $jobCards = $full_model_class::where('jobcard_id', $get_certificate[0]->jobcard_id)
                    ->with(['metalss', 'clarityss', 'colorss', 'cutss']) // Load related data
                    ->get();
                    $url = url('/print-certificates?ids=on,' .$get_certificate[0]->jobcard_id);
                    $qrCode = QrCode::size(200)->generate($url);
                        $pdf = PDF::loadView('certificate_template', compact('jobCards','qrCode'));
                        // Return PDF as download or open in browser
                        return $pdf->stream('certificates.pdf');
            }
        }else{
            return back()->with('error', 'No data');
        }
    }
}