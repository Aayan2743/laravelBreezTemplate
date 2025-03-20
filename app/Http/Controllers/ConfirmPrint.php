<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\confirmentrys;
use App\Models\confirmitemstables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class ConfirmPrint extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        


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


    public function printCertificates(Request $request,$id)
    {
       
       
     
        $jobCards = confirmitemstables::where('confirmid', $id)
        ->with(['client_details','confirmEntryDetails','serviceDetails']) // Load related data
        ->get();    
      
        $totalNop = $jobCards->sum('nop');
       //  dd($jobCards);
  
      $url = url('/print-gems-card-certificates?ids=on,' . $id);
   

    $qrCode = QrCode::size(200)->generate($url);

   
        $pdf = PDF::loadView('confirmation_certificate_template', compact('jobCards','qrCode','totalNop'));

        // Return PDF as download or open in browser
        return $pdf->stream('confirmation.pdf');
    }
}
