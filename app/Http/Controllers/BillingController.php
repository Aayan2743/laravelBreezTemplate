<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\confirmentrys;

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
        // $confirmentrysdetails = $query->paginate($perPage);

        $confirmentrysdetails = $query->paginate($perPage)
                             ->appends([
                                 'search' => $request->search,
                                 'per_page' => $perPage
                             ]);
           // dd($confirmentrysdetails);

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


}
