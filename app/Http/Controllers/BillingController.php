<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\confirmentrys;
use App\Models\servicetype;
use App\Models\ratecards;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        





        $query = confirmentrys::select('confirmentry.*', 'clientinformation.client_name')
            ->join('clientinformation', 'confirmentry.client_id', '=', 'clientinformation.client_id')
            ->orderBy('confirmentry.conf_id', 'desc');

       

        if ($request->has('search')) {
            $query->where('confirmentry.confirmationid', 'like', '%' . $request->search . '%')
                ->orWhere('clientinformation.client_name', 'like', '%' . $request->search . '%')
                ->orWhere('confirmentry.depositer_name', 'like', '%' . $request->search . '%');
        }
        $perPage = $request->input('per_page', 8);
    
        $confirmentrysdetails = $query->paginate($perPage)
                             ->appends([
                                 'search' => $request->search,
                                 'per_page' => $perPage
                             ]);
        
        //  dd($confirmentrysdetails);                           

        if ($request->ajax()) {
            return view('partials.billing_table', compact('confirmentrysdetails'))->render();
        }

        return view('billing', compact('confirmentrysdetails'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printSingleCertificate($id)
    {
        // Fetch single job card with relationships
        $jobCard = confirmentrys::where('jobcard_id', $id)
            ->with(['metalss', 'clarityss', 'colorss', 'cutss'])
            ->firstOrFail(); // Ensure it exists

        // Generate QR Code with a single job card ID
        $url = url('/print-certificate/' . $id);
        $qrCode = QrCode::size(200)->generate($url);

        // Load view into PDF
        $pdf = PDF::loadView('certificate_template', compact('jobCard', 'qrCode'));

        // Return PDF as stream
        return $pdf->stream('certificate_' . $id . '.pdf');
    }



    public function getReport($id){

        // creating Invoice No
        $year = Carbon::now()->year;
        $financialYear = substr($year, -2) . '-' . substr($year + 1, -2);
        
        $invoice_number="INV/".$financialYear."/".$id;

        $client_details=confirmentrys::with(['client_details','diamond_jobs'])->where('confirmationid',$id)->get();
        
        // dd($client_details);
     
        $receivedDate=$client_details[0]->recievedate;
       
        $clientName=$client_details[0]->client_details->client_name;
        $clientAddress=$client_details[0]->client_details->address;

        // Checking the confirmid on each service
        $diamond_jobs_service = optional($client_details[0]->diamond_jobs)->service;
       

        $array_of_all_services=[];
        if($diamond_jobs_service){
            // geting the rate card
            $grwt=$client_details[0]->diamond_jobs->estwt;
            $get_service_id=servicetype::where('servicetypes_names',$diamond_jobs_service)->value('servicetypes_id');
            $get_rates=ratecards::where('servicetype_id',$get_service_id)->get();
            $qty=$client_details[0]->diamond_jobs->nol;
            $final_rate;
            $final_range;
            $final_ext;
            foreach($get_rates as $rate){
                //  dd($rate->wt , $grwt) ;
                if ($grwt >= $rate->wt ) {
                    $final_rate=$rate->rate;
                    $final_range=$rate->caratwt;
                    $final_ext=$rate->ext;

                }
            }


            $array_of_all_services = [
                'rate' => $final_rate,
                'range' => $final_range,
                'grwt' => $grwt,
                'service' => $diamond_jobs_service,
                'extension' => $final_ext,
                'quantity' => $qty,
                'amount' => $grwt*$final_rate
            ];
            // dd($final_rate,$final_range,$diamond_jobs_service,$final_ext,$qty);

        }else{
            
        }

        $pdf = PDF::loadView('invoicePrint', [
            'services' => $array_of_all_services,
            'invoice_number' => $invoice_number,
            'clientName' => $clientName,
            'clientAddress' => $clientAddress,
            'receivedDate' => $receivedDate
        ]);
        // $pdf = PDF::loadView('invoicePrint', compact('array_of_all_services','invoice_number','clientName','clientAddress','receivedDate'));

        // Return PDF as download or open in browser
        return $pdf->stream('invoice.pdf');

        dd($array_of_all_services);

        dd($diamond_jobs_service);
        dd($client_details[0]->diamond_jobs->service);

       
        

    }


}
