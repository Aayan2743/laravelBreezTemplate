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



    public function getReport1($id){

        // creating Invoice No
        $year = Carbon::now()->year;
        $financialYear = substr($year, -2) . '-' . substr($year + 1, -2);
        
        $invoice_number="INV/".$financialYear."/".$id;

        // $client_details=confirmentrys::with(['client_details','diamond_jobs','gemstone_jobs'])->where('confirmationid',$id)->get();
        $client_details=confirmentrys::with(['client_details','diamond_jobs','gemstone_jobs','diamonds_card_jobs','gem_jewellery_card_jobs','uncut_jewellery_card'])->where('confirmationid',$id)->get();

      
        
      
      
        $receivedDate=$client_details[0]->recievedate;
        $clientName=$client_details[0]->client_details->client_name;
        $clientAddress=$client_details[0]->client_details->address;
        

        $diamond_data =[];
        $gemstone_data  =[];
        $diamond_card_data  =[];
        $gem_jewellery_card_job  =[];
        $uncut_jewellery_data  =[];

        // new
       
        if ($client_details[0]->diamond_jobs->isNotEmpty()) {
            $diamond_jobs_service_total_amount = 0;
            foreach ($client_details[0]->diamond_jobs as $diamond_job) {

              
                $diamond_jobs_service = optional($diamond_job)->service;
             
                if ($diamond_jobs_service) {
                    $grwt = $diamond_job->estwt;
                   

                   
                  
                    
                    $get_service_id = servicetype::where('servicetypes_names', $diamond_jobs_service)->value('servicetypes_id');
                  
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                    $qty = $diamond_job->nol;
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
                  
                    foreach ($get_rates as $rate) {
                       
                        if ($grwt >= $rate->wt) {
                          
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $grwt * $final_rate;
                    $diamond_jobs_service_total_amount += $amount;
                  
                    $diamond_data[] = [
                        'service_type' => 'Diamond',
                        'service' => $diamond_jobs_service,
                        'grwt' => $grwt,
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => $qty,
                        'amount' => $grwt * $final_rate,
                      
                    ];

                   
                  
                }
               
            }
            
        }

        // dd( $diamond_jobs_service_total_amount);


        if ($client_details[0]->gemstone_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gemstone_jobs as $gemstone_job) {
                $gemstone_jobs_service = optional($gemstone_job)->service;
                $gemstone_jobs_service_total_amount = 0;
                if ($gemstone_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $gemstone_jobs_service)->value('servicetypes_id');
                   
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    
                    $amount = $carat * $final_rate;
                    $gemstone_jobs_service_total_amount += $amount;

                    
                    $gemstone_data[] = [
                        'service_type' => 'Gemstone',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }

       
        if ($client_details[0]->diamonds_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->diamonds_card_jobs as $gemstone_job) {
                $diamonCard_jobs_service = optional($gemstone_job)->service;
                      
                $diamonds_jobs_service_total_amount = 0;
            


                if ($diamonCard_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $diamonCard_jobs_service)->value('servicetypes_id');
                 
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                 
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
        
                    $amount = $carat * $final_rate;
                    $diamonds_jobs_service_total_amount += $amount;
                    $diamond_card_data[] = [
                        'service_type' => 'Diamond Job',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }


        //gem_jewellery_card_job
        if ($client_details[0]->gem_jewellery_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gem_jewellery_card_jobs as $gemstone_job) {
                $gem_jewellery_card = optional($gemstone_job)->service;
                        
                $gem_jewellery_card_jobs_total = 0;
              


                if ($gem_jewellery_card) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $gem_jewellery_card)->value('servicetypes_id');
               
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }

                    $amount = $carat * $final_rate;
                    $gem_jewellery_card_jobs_total += $amount;
        
                    $gem_jewellery_card_job[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $gem_jewellery_card,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }

        // uncut jewellery    
        if ($client_details[0]->uncut_jewellery_card->isNotEmpty()) {
            foreach ($client_details[0]->uncut_jewellery_card as $gemstone_job) {
                $uncut_jewellery_service = optional($gemstone_job)->service;

                $uncut_jewellery_card_total = 0;
               


                if ($uncut_jewellery_service) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $uncut_jewellery_service)->value('servicetypes_id');
             
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $carat * $final_rate;
                    $uncut_jewellery_card_total += $amount;
        
                    $uncut_jewellery_data[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $uncut_jewellery_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }






        $sub_total= $diamond_jobs_service_total_amount+$gemstone_jobs_service_total_amount+$diamonds_jobs_service_total_amount+$gem_jewellery_card_jobs_total+$uncut_jewellery_card_total;
        
        $gst_18=(0.18)*$sub_total;
        
        $total_final_amount= $sub_total+$gst_18;

       
        // dd(storage_path('app/public/uploads/1741164180.jpg'));

        $path = public_path('uploads/1741164180.jpg');

            if (file_exists($path) && is_readable($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                // dd("File not found or not readable at: " . $path);
            }




            
        $array_of_all_services = [
            'diamond' => $diamond_data,
            'diamond_jobs_service_total_amount' => $diamond_jobs_service_total_amount,
            'gemstone' => $gemstone_data,
            'gemstone_jobs_service_total_amount' => $gemstone_jobs_service_total_amount,
            'diamondcard' => $diamond_card_data,
            'diamonds_jobs_service_total_amount' => $diamonds_jobs_service_total_amount,
            'gemjewellerycard' => $gem_jewellery_card_job,
            'gem_jewellery_card_jobs_total' => $gem_jewellery_card_jobs_total,
            'uncutjewellery' => $uncut_jewellery_data,
            'uncut_jewellery_card_total' => $uncut_jewellery_card_total,
            'sub_total'=>$sub_total,
            'gst'=>$gst_18,
            'total_final_amount'=>$total_final_amount,
            // 'base64Image'=>$base64Image,
        ];   


        // dd($array_of_all_services);
       
           
            
        

    
        // $pdf = PDF::loadView('your-view')->setPaper('A4', 'landscape');
       
        $pdf = PDF::loadView('invoicePrint', [
            'services' => $array_of_all_services,
            'invoice_number' => $invoice_number,
            'clientName' => $clientName,
            'clientAddress' => $clientAddress,
            'receivedDate' => $receivedDate
        ])->setPaper('A4', 'landscape');

        // $pdf = PDF::loadView('invoicePrint', compact('array_of_all_services','invoice_number','clientName','clientAddress','receivedDate'));

        // Return PDF as download or open in browser
        return $pdf->stream('invoice.pdf');

        dd($array_of_all_services);

        dd($diamond_jobs_service);
        dd($client_details[0]->diamond_jobs->service);

       
        

    }

    
    public function getReport($id){

        // creating Invoice No
        $year = Carbon::now()->year;
        $financialYear = substr($year, -2) . '-' . substr($year + 1, -2);
        
        $invoice_number="INV/".$financialYear."/".$id;

        // $client_details=confirmentrys::with(['client_details','diamond_jobs','gemstone_jobs'])->where('confirmationid',$id)->get();
        $client_details=confirmentrys::with(['client_details',
        'diamond_jobs',
        'extraCharges',
        'gemstone_jobs',
        'diamonds_card_jobs',
        'gem_jewellery_card_jobs',
        'uncut_jewellery_card'])->where('confirmationid',$id)->get();

        // dd($client_details[0]->extraCharges);

        // dd($client_details[0]->extraCharges[0]->serviceName);
        
      
       

      
        $receivedDate=$client_details[0]->recievedate;
        $clientName=$client_details[0]->client_details->client_name;
        $clientAddress=$client_details[0]->client_details->address;
        

        $diamond_data =[];
        $gemstone_data  =[];
        $diamond_card_data  =[];
        $gem_jewellery_card_job  =[];
        $uncut_jewellery_data  =[];
        $extrachargesdata  =[];
        $totalExtraCharges = 0;

        if ($client_details[0]->extraCharges->isNotEmpty()) {
            foreach ($client_details[0]->extraCharges as $extracharges) {

               
                $totalExtraCharges += $extracharges->price; 
                //   dd($extracharges->serviceName->servicetypes_names)  ;
                $extrachargesdata[] = [
                    'extracharges' => $extracharges,
                    'serviceName' => $extracharges->serviceName->servicetypes_names,
                   
                ];

            }
        }

        

        // new
       
        if ($client_details[0]->diamond_jobs->isNotEmpty()) {
            $diamond_jobs_service_total_amount = 0;
            foreach ($client_details[0]->diamond_jobs as $diamond_job) {

              
                $diamond_jobs_service = optional($diamond_job)->service;
             
                if ($diamond_jobs_service) {
                    $grwt = $diamond_job->estwt;
                   

                   
                  
                    
                    $get_service_id = servicetype::where('servicetypes_names', $diamond_jobs_service)->value('servicetypes_id');
                  
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                    $qty = $diamond_job->nol;
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
                  
                    foreach ($get_rates as $rate) {
                       
                        if ($grwt >= $rate->wt) {
                          
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $grwt * $final_rate;
                    $diamond_jobs_service_total_amount += $amount;
                  
                    $diamond_data[] = [
                        'service_type' => 'Diamond',
                        'service' => $diamond_jobs_service,
                        'grwt' => $grwt,
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => $qty,
                        'amount' => $grwt * $final_rate,
                      
                    ];

                   
                  
                }
               
            }
            
        }

        // dd( $diamond_jobs_service_total_amount);


        if ($client_details[0]->gemstone_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gemstone_jobs as $gemstone_job) {
                $gemstone_jobs_service = optional($gemstone_job)->service;
                $gemstone_jobs_service_total_amount = 0;
                if ($gemstone_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $gemstone_jobs_service)->value('servicetypes_id');
                   
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    
                    $amount = $carat * $final_rate;
                    $gemstone_jobs_service_total_amount += $amount;

                    
                    $gemstone_data[] = [
                        'service_type' => 'Gemstone',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }

       
        if ($client_details[0]->diamonds_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->diamonds_card_jobs as $gemstone_job) {
                $diamonCard_jobs_service = optional($gemstone_job)->service;
                      
                $diamonds_jobs_service_total_amount = 0;
            


                if ($diamonCard_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $diamonCard_jobs_service)->value('servicetypes_id');
                 
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                 
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
        
                    $amount = $carat * $final_rate;
                    $diamonds_jobs_service_total_amount += $amount;
                    $diamond_card_data[] = [
                        'service_type' => 'Diamond Job',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }


        //gem_jewellery_card_job
        if ($client_details[0]->gem_jewellery_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gem_jewellery_card_jobs as $gemstone_job) {
                $gem_jewellery_card = optional($gemstone_job)->service;
                        
                $gem_jewellery_card_jobs_total = 0;
              


                if ($gem_jewellery_card) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $gem_jewellery_card)->value('servicetypes_id');
               
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }

                    $amount = $carat * $final_rate;
                    $gem_jewellery_card_jobs_total += $amount;
        
                    $gem_jewellery_card_job[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $gem_jewellery_card,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }

        // uncut jewellery    
        if ($client_details[0]->uncut_jewellery_card->isNotEmpty()) {
            foreach ($client_details[0]->uncut_jewellery_card as $gemstone_job) {
                $uncut_jewellery_service = optional($gemstone_job)->service;

                $uncut_jewellery_card_total = 0;
               


                if ($uncut_jewellery_service) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $uncut_jewellery_service)->value('servicetypes_id');
             
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $carat * $final_rate;
                    $uncut_jewellery_card_total += $amount;
        
                    $uncut_jewellery_data[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $uncut_jewellery_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }






        $sub_total= $diamond_jobs_service_total_amount+$gemstone_jobs_service_total_amount+$diamonds_jobs_service_total_amount+$gem_jewellery_card_jobs_total+$uncut_jewellery_card_total;
        
        $gst_18=(0.18)*$sub_total;
        
        $total_final_amount= $sub_total+$gst_18+$totalExtraCharges;

       
        // dd(storage_path('app/public/uploads/1741164180.jpg'));

        $path = public_path('uploads/1741164180.jpg');

            if (file_exists($path) && is_readable($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                // dd("File not found or not readable at: " . $path);
            }




            
        $array_of_all_services = [
            'diamond' => $diamond_data,
            'diamond_jobs_service_total_amount' => $diamond_jobs_service_total_amount,
            'gemstone' => $gemstone_data,
            'gemstone_jobs_service_total_amount' => $gemstone_jobs_service_total_amount,
            'diamondcard' => $diamond_card_data,
            'diamonds_jobs_service_total_amount' => $diamonds_jobs_service_total_amount,
            'gemjewellerycard' => $gem_jewellery_card_job,
            'gem_jewellery_card_jobs_total' => $gem_jewellery_card_jobs_total,
            'uncutjewellery' => $uncut_jewellery_data,
            'uncut_jewellery_card_total' => $uncut_jewellery_card_total,
            'sub_total'=>$sub_total,
            'gst'=>$gst_18,
            'total_final_amount'=>$total_final_amount,
            'extrachargesdata'=>$extrachargesdata,
            'totalExtraCharges'=>$totalExtraCharges,
            // 'base64Image'=>$base64Image,
        ];   


        // dd($array_of_all_services);
       
           
            
        

    
        // $pdf = PDF::loadView('your-view')->setPaper('A4', 'landscape');
       
        $pdf = PDF::loadView('invoicePrint', [
            'services' => $array_of_all_services,
            'invoice_number' => $invoice_number,
            'clientName' => $clientName,
            'clientAddress' => $clientAddress,
            'receivedDate' => $receivedDate
        ])->setPaper('A4', 'landscape');

        // $pdf = PDF::loadView('invoicePrint', compact('array_of_all_services','invoice_number','clientName','clientAddress','receivedDate'));

        // Return PDF as download or open in browser
        return $pdf->stream('invoice.pdf');

        dd($array_of_all_services);

        dd($diamond_jobs_service);
        dd($client_details[0]->diamond_jobs->service);

       
        

    }


    public function getReportWithLogo($id){

        // creating Invoice No
        $year = Carbon::now()->year;
        $financialYear = substr($year, -2) . '-' . substr($year + 1, -2);
        
        $invoice_number="INV/".$financialYear."/".$id;

        // $client_details=confirmentrys::with(['client_details','diamond_jobs','gemstone_jobs'])->where('confirmationid',$id)->get();
        $client_details=confirmentrys::with(['client_details',
        'diamond_jobs',
        'extraCharges',
        'gemstone_jobs',
        'diamonds_card_jobs',
        'gem_jewellery_card_jobs',
        'uncut_jewellery_card'])->where('confirmationid',$id)->get();

        // dd($client_details[0]->extraCharges);

        // dd($client_details[0]->extraCharges[0]->serviceName);
        
      
       

      
        $receivedDate=$client_details[0]->recievedate;
        $clientName=$client_details[0]->client_details->client_name;
        $clientAddress=$client_details[0]->client_details->address;
        

        $diamond_data =[];
        $gemstone_data  =[];
        $diamond_card_data  =[];
        $gem_jewellery_card_job  =[];
        $uncut_jewellery_data  =[];
        $extrachargesdata  =[];
        $totalExtraCharges = 0;

        if ($client_details[0]->extraCharges->isNotEmpty()) {
            foreach ($client_details[0]->extraCharges as $extracharges) {

               
                $totalExtraCharges += $extracharges->price; 
                //   dd($extracharges->serviceName->servicetypes_names)  ;
                $extrachargesdata[] = [
                    'extracharges' => $extracharges,
                    'serviceName' => $extracharges->serviceName->servicetypes_names,
                   
                ];

            }
        }

        

        // new
       
        if ($client_details[0]->diamond_jobs->isNotEmpty()) {
            $diamond_jobs_service_total_amount = 0;
            foreach ($client_details[0]->diamond_jobs as $diamond_job) {

              
                $diamond_jobs_service = optional($diamond_job)->service;
             
                if ($diamond_jobs_service) {
                    $grwt = $diamond_job->estwt;
                   

                   
                  
                    
                    $get_service_id = servicetype::where('servicetypes_names', $diamond_jobs_service)->value('servicetypes_id');
                  
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                    $qty = $diamond_job->nol;
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
                  
                    foreach ($get_rates as $rate) {
                       
                        if ($grwt >= $rate->wt) {
                          
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $grwt * $final_rate;
                    $diamond_jobs_service_total_amount += $amount;
                  
                    $diamond_data[] = [
                        'service_type' => 'Diamond',
                        'service' => $diamond_jobs_service,
                        'grwt' => $grwt,
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => $qty,
                        'amount' => $grwt * $final_rate,
                      
                    ];

                   
                  
                }
               
            }
            
        }

        // dd( $diamond_jobs_service_total_amount);


        if ($client_details[0]->gemstone_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gemstone_jobs as $gemstone_job) {
                $gemstone_jobs_service = optional($gemstone_job)->service;
                $gemstone_jobs_service_total_amount = 0;
                if ($gemstone_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $gemstone_jobs_service)->value('servicetypes_id');
                   
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
        
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    
                    $amount = $carat * $final_rate;
                    $gemstone_jobs_service_total_amount += $amount;

                    
                    $gemstone_data[] = [
                        'service_type' => 'Gemstone',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }

       
        if ($client_details[0]->diamonds_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->diamonds_card_jobs as $gemstone_job) {
                $diamonCard_jobs_service = optional($gemstone_job)->service;
                      
                $diamonds_jobs_service_total_amount = 0;
            


                if ($diamonCard_jobs_service) {
                    $carat = $gemstone_job->carat;
                    $get_service_id = servicetype::where('servicetypes_names', $diamonCard_jobs_service)->value('servicetypes_id');
                 
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                 
                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
        
                    $amount = $carat * $final_rate;
                    $diamonds_jobs_service_total_amount += $amount;
                    $diamond_card_data[] = [
                        'service_type' => 'Diamond Job',
                        'service' => $gemstone_jobs_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                  
                }
            }
        }


        //gem_jewellery_card_job
        if ($client_details[0]->gem_jewellery_card_jobs->isNotEmpty()) {
            foreach ($client_details[0]->gem_jewellery_card_jobs as $gemstone_job) {
                $gem_jewellery_card = optional($gemstone_job)->service;
                        
                $gem_jewellery_card_jobs_total = 0;
              


                if ($gem_jewellery_card) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $gem_jewellery_card)->value('servicetypes_id');
               
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }

                    $amount = $carat * $final_rate;
                    $gem_jewellery_card_jobs_total += $amount;
        
                    $gem_jewellery_card_job[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $gem_jewellery_card,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }

        // uncut jewellery    
        if ($client_details[0]->uncut_jewellery_card->isNotEmpty()) {
            foreach ($client_details[0]->uncut_jewellery_card as $gemstone_job) {
                $uncut_jewellery_service = optional($gemstone_job)->service;

                $uncut_jewellery_card_total = 0;
               


                if ($uncut_jewellery_service) {
                    $carat = $gemstone_job->estwt;
                  
                    $get_service_id = servicetype::where('servicetypes_names', $uncut_jewellery_service)->value('servicetypes_id');
             
                    $get_rates = ratecards::where('servicetype_id', $get_service_id)->get();
                   

                    $final_rate = null;
                    $final_range = null;
                    $final_ext = null;
        
                    foreach ($get_rates as $rate) {
                        if ($carat >= $rate->wt) {
                            $final_rate = $rate->rate;
                            $final_range = $rate->caratwt;
                            $final_ext = $rate->ext;
                        }
                    }
                    $amount = $carat * $final_rate;
                    $uncut_jewellery_card_total += $amount;
        
                    $uncut_jewellery_data[] = [
                        'service_type' => 'Gems Jewellery Service',
                        'service' => $uncut_jewellery_service,
                        'grwt' => $carat, // Using carat instead of grwt
                        'rate' => $final_rate,
                        'range' => $final_range,
                        'extension' => $final_ext,
                        'quantity' => '-', // No quantity for gemstones
                        'amount' => $carat * $final_rate
                    ];

                   
                  
                }
            }
        }






        $sub_total= $diamond_jobs_service_total_amount+$gemstone_jobs_service_total_amount+$diamonds_jobs_service_total_amount+$gem_jewellery_card_jobs_total+$uncut_jewellery_card_total;
        
        $gst_18=(0.18)*$sub_total;
        
        $total_final_amount= $sub_total+$gst_18+$totalExtraCharges;

       
        // dd(storage_path('app/public/uploads/1741164180.jpg'));

        $path = public_path('uploads/1741164180.jpg');

            if (file_exists($path) && is_readable($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                // dd("File not found or not readable at: " . $path);
            }




            
        $array_of_all_services = [
            'diamond' => $diamond_data,
            'diamond_jobs_service_total_amount' => $diamond_jobs_service_total_amount,
            'gemstone' => $gemstone_data,
            'gemstone_jobs_service_total_amount' => $gemstone_jobs_service_total_amount,
            'diamondcard' => $diamond_card_data,
            'diamonds_jobs_service_total_amount' => $diamonds_jobs_service_total_amount,
            'gemjewellerycard' => $gem_jewellery_card_job,
            'gem_jewellery_card_jobs_total' => $gem_jewellery_card_jobs_total,
            'uncutjewellery' => $uncut_jewellery_data,
            'uncut_jewellery_card_total' => $uncut_jewellery_card_total,
            'sub_total'=>$sub_total,
            'gst'=>$gst_18,
            'total_final_amount'=>$total_final_amount,
            'extrachargesdata'=>$extrachargesdata,
            'totalExtraCharges'=>$totalExtraCharges,
            // 'base64Image'=>$base64Image,
        ];   


        // dd($array_of_all_services);
       
           
            
        

    
        // $pdf = PDF::loadView('your-view')->setPaper('A4', 'landscape');
       
        $pdf = PDF::loadView('invoicePrintLogo', [
            'services' => $array_of_all_services,
            'invoice_number' => $invoice_number,
            'clientName' => $clientName,
            'clientAddress' => $clientAddress,
            'receivedDate' => $receivedDate
        ])->setPaper('A4', 'landscape');

        // $pdf = PDF::loadView('invoicePrint', compact('array_of_all_services','invoice_number','clientName','clientAddress','receivedDate'));

        // Return PDF as download or open in browser
        return $pdf->stream('invoice.pdf');

        dd($array_of_all_services);

        dd($diamond_jobs_service);
        dd($client_details[0]->diamond_jobs->service);

       
        

    }


}
