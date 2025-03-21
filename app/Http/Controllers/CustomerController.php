<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\state;
use App\Models\citie;
use App\Models\service;
use App\Models\ratecards;
use App\Models\clientinformationDetails;
use App\Models\clientcompanylogoData;
use App\Models\confirmitemstables;
use App\Models\confirmentrys;
// use validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //


    public function confirmEntryShow(Request $request){

        // $query = confirmentrys::orderBy('conf_id', 'desc');

        // if ($request->has('search')) {
        //     $query->where('confirmationid', 'like', '%' . $request->search . '%')
        //           ->orWhere('client_id', 'like', '%' . $request->search . '%')
        //           ->orWhere('depositer_name', 'like', '%' . $request->search . '%');
        // }
    
        // $confirmentrysdetails = $query->paginate(8);
    
        // if ($request->ajax()) {
        //     return view('partials.confirmEntry_table', compact('confirmentrysdetails'))->render();
        // }

        // return view('viewConfirmEntry',compact('confirmentrysdetails'));

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
            return view('partials.confirmEntry_table', compact('confirmentrysdetails'))->render();
        }

        return view('viewConfirmEntry', compact('confirmentrysdetails'));














    }


    public function add_clientinformation(Request $req){

      


        $validator = Validator::make($req->all(), [
            'depname' => 'required|string',
            'mobile' => 'required|digits:10',
            'depadd' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'retailer' => 'required|string',
            'supplier' => 'required|string',
            'depositor' => 'required|string',
        ], [
            'depname.required' => 'Client Name Required',
            'mobile.required' => 'Mobile No Required',
            'mobile.digits' => 'Mobile No Allowed Only digits',
            'depadd.required' => 'Client Address Required',
            'state.required' => 'Client State Required',
            'city.required' => 'Client City Required',
            'retailer.required' => 'Retailer  Required',
            'supplier.required' => 'Supplier  Required',
            'depositor.required' => 'Depositor  Required',
        ]);
    
        if ($validator->fails()) {
            // Redirect back with input and validation errors
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validation failed! Please check the inputs.')
                ->withInput();
        }
    
      
        try {
            $create_order = clientinformationDetails::updateOrCreate(
                // Condition to check if the record exists
                //  ['email' => $req->email], // You can change this to another unique identifier like 'client_name'
                 ['client_id' => $req->client_id ?? null],
                // Data to insert or update
                [
                    'client_name' => $req->depname,
                    'address' => $req->depadd,
                    'retailer' => $req->retailer,
                    'supplier' => $req->supplier,
                    'depositorname' => $req->depositor,
                    'phonenumber' => $req->mobile,
                    'email' => $req->email,
                    'panno' => $req->panno,
                    'tanno' => $req->tanno,
                    'gstno' => $req->gstno,
                    'state' => $req->state,
                    'city' => $req->city,
                    'country' => 'India',
                    'other_city' => $req->ancity,
                    'dj1' => $req->rate1,
                    'dj2' => $req->rate2,
                    'sdj1' => $req->rate3,
                    'sdj2' => $req->rate4,
                    'dg1' => $req->rate5,
                    'dg2' => $req->rate6,
                    'sdg1' => $req->rate7,
                    'sdg2' => $req->rate8,
                    'gls1' => $req->rate9,
                    'gls2' => $req->rate10,
                    'gls3' => $req->rate11,
                    'gls4' => $req->rate12,
                    'cvd2' => $req->rate14,
                    'cvd3' => $req->rate15,
                    'cvd4' => $req->rate16,
                    'un1' => $req->rate17,
                    'un2' => $req->rate18,
                    'carat1' => $req->carat1,
                    'carat2' => $req->carat2,
                    'carat3' => $req->carat3,
                    'carat4' => $req->carat4,
                    'carat5' => $req->carat5,
                    'carat6' => $req->carat6,
                    'carat7' => $req->carat7,
                    'carat8' => $req->carat8,
                    'carat9' => $req->carat9,
                    'carat10' => $req->carat10,
                    'carat11' => $req->carat11,
                    'carat12' => $req->carat12,
                    'carat13' => $req->depname,
                    'carat14' => $req->carat14,
                    'carat15' => $req->carat15,
                    'carat16' => $req->carat16,
                    'carat17' => $req->carat17,
                    'carat18' => $req->carat18,
                ]
            );
        
            return redirect()->back()->with('success', 'Client information saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save client information. Please try again.');
        }
        
        
       

    }

    public function deleteClientById($id){
        $clientinformation=clientinformationDetails::findOrfail($id);

        $clientinformation->delete();

        return redirect()->back()->with('success', 'Client deleted successfully!');
        // dd($clientinformation);
    }

    public function cobrandingDelete($id){
        $clientinformation=clientcompanylogoData::findOrfail($id);

        $clientinformation->delete();

        return redirect()->back()->with('success', 'Co-Branding  deleted successfully!');
        // dd($clientinformation);
    }

    public function updateConfirmDelete($id){
        $clientinformation=confirmentrys::where('confirmationid',$id)->delete();
        $clientinformation=confirmitemstables::where('client_id',$id)->delete();

        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Confirm Entry deleted successfully!');
        // dd($clientinformation);
    }

    

    
    



    public function create(){

        $states=state::where('country_id',100)->get();
        
        $rates=ratecards::get();

        //  dd($rates);

        return view('addCustomer',compact('states','rates'));
    }

    public function viewClients(Request $request){
        
    
        $query = clientinformationDetails::orderBy('client_id', 'desc');

        if ($request->has('search')) {
            $query->where('client_name', 'like', '%' . $request->search . '%')
                  ->orWhere('supplier', 'like', '%' . $request->search . '%');
        }
    
        $clientinformation = $query->paginate(8);
    
        if ($request->ajax()) {
            return view('partials.client_table', compact('clientinformation'))->render();
        }
    
        return view('viewClients', compact('clientinformation'));


    }

    public function viewClientById($id){

        $clientinformation=clientinformationDetails::findOrFail($id);

        $states=state::where('country_id',100)->get();
        
        // $cities=$clientinformation->city;
        $cities = citie::where('state_id', $clientinformation->state)->get();
       // dd($cities);

    return view('editCustomer',compact('states','clientinformation','cities'));

    }

    public function getCities(Request $request)
    {

        //dd($request->state_id);
        $cities = citie::where('state_id', $request->state_id)->get(); // Fetch cities by state_id
        return response()->json($cities); // Return JSON response
    }

    public function getCitiesData($state_id)
        {
            $cities = citie::where('state_id', $state_id)->get();
            return response()->json($cities);
        }


     public function cobranding_index($id){

        
        // use 274
        $clientdetails=clientinformationDetails::where('client_id',$id)->get();

        $cobranding=clientcompanylogoData::where('client_id',$id)->get();

        // dd($cobranding);

        return view('clientCobranding',compact('cobranding','clientdetails'));
     }   

     public function cobrandingStore(Request $request){

        $request->validate([
            'coBrandingImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'coBrandingText' => 'required|string|max:255',
            'clinetID' => 'required',
        ]);

        // Handle file upload
        if ($request->hasFile('coBrandingImage')) {
            $imagePath = $request->file('coBrandingImage')->store('uploads', 'public'); // Save to storage/app/public/uploads
        } else {
            return back()->with('error', 'Image upload failed.');
        }

        // Save data to database
        clientcompanylogoData::create([
            'logoname' => $imagePath,
            'logotext' => $request->coBrandingText,
            'client_id' => $request->clinetID,
            'status' => 0,
        ]);

        return back()->with('success', 'Co-branding added successfully!');

     }

     public function brandingupdate(Request $request){

        $request->validate([
            'clinetEditID' => 'required',
            'coBrandingEditText' => 'required',
            'coBrandingImageEdit' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $client=clientcompanylogoData::find($request->clinetEditID);
        // $client = clientcompanylogoData::where('id',$request->clinetEditID)->first();
        //  dd($client);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
    
        // Update text field
        $client->logotext = $request->coBrandingEditText;
    
        // Handle image upload
        if ($request->hasFile('coBrandingImageEdit')) {
            // Delete old image if exists
            if ($client->logoname) {
                Storage::delete('public/' . $client->logoname);
            }
            
            // Store new image
            $path = $request->file('coBrandingImageEdit')->store('uploads', 'public');
            $client->logoname = $path;
        }
    
        $client->save();
        return back()->with('success', 'Co-branding Updated successfully!');
        // return response()->json(['success' => 'Updated successfully', 'image' => $client->logoname, 'text' => $client->logotext]);
     }


     public function confirmEntryIndex($id){

        $customerDetails=clientinformationDetails::findOrFail($id);
        
        $companyLogo=clientcompanylogoData::where('client_id',$id)->get();
        $services=service::get();

        return view('confirmEntry',compact('customerDetails','companyLogo','services'));

     }

     public function confirmEntryEdit($id){

            
        // dd($id);
        $confirmentrys=confirmentrys::where('confirmationid',$id)->get();

        //dd($confirmentrys);
        //  dd($confirmentrys[0]->company_logo);
      
        $customerDetails=clientinformationDetails::findOrFail($confirmentrys[0]->client_id); 
        $confirmitemstables=confirmitemstables::where('confirmid',$id)->get();
        
        // dd($confirmitemstables);
        $companyLogo=clientcompanylogoData::where('client_id',$confirmentrys[0]->client_id)->get();
       // dd($companyLogo);
        $services=service::get();

        return view('confirmEntryEdit',compact('customerDetails','companyLogo','services','confirmentrys','confirmitemstables'));

     }

     public function confirmEntryUpdate(Request $req){
       
        
        

       

      $validator = Validator::make($req->all(), [
            // 'depname' => 'required|string',
            'client_ids' => 'required',
            'logo' => 'required',
            'DepositorName' => 'required|string',
            'ReceiverName' => 'required|string',
            'InvoiceDate' => 'required|date',
            'Deliverydate' => 'required|date',

         
        ], [
            'depname.required' => 'Client Name Required',
          
        ]);

        

        if ($validator->fails()) {
            // Redirect back with input and validation errors
        
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validation failed! Please check the inputs.')
                ->withInput();
        }



        try {
            DB::beginTransaction();

            $client_unique_id=confirmentrys::where('confirmationid',$req->client_ids)->get();

            // dd($client_unique_id[0]->client_id);

            $confirmationsupdates=confirmentrys::where('confirmationid',$req->client_ids)->update([
                'depositer_name'=>$req->DepositorName,
                'reciever'=>$req->ReceiverName,
                'invoicedate'=>$req->InvoiceDate,
                'deliverydate'=>$req->Deliverydate,
                'company_logo' => $req->logo,
            ]);
           


           
    
            // Fetch existing items
            $existingItems = confirmitemstables::where('confirmid', $req->client_ids)->get();
            $processedItemIds = [];
    
            // Loop through the items array
            foreach ($req->item as $key => $item) {

              



                $confItemId = $req->conf_item[$key] ?? null;
                
                if ($confItemId) {
                    // If conf_item exists, update the item
                    $confirmItem = confirmitemstables::where('conf_item', $confItemId)->first();
                    if ($confirmItem) {
                        $confirmItem->update([
                            'item' => $item,
                            'nop' => $req->pieces[$key],
                            'weight' => $req->weight[$key],
                            'services' => $req->service[$key],
                            'client_id' => $client_unique_id[0]->client_id,
                        ]);
                        $processedItemIds[] = $confirmItem->conf_item;
                    }
                } else {

                  
                    $lastEntry = Confirmentrys::orderBy('conf_id', 'desc')->first();
                    $lastEntry1 = confirmitemstables::orderBy('conf_item', 'desc')->first();
                    $lastId = $lastEntry ? $lastEntry->conf_id : 0;     
                    $lastId1 = $lastEntry1 ? $lastEntry1->conf_item : 0;     
            
                    // $confirmId = 'GIL' . $financialYearCode . 'CNF' . $lastId+1;
                    // $confirmId1 = 'GIL' . $financialYearCode . 'CNF' . $lastId1+1;


                    // Otherwise, create a new item
                    $newItem = confirmitemstables::create([
                        'confirmid'=>$req->client_ids,
                        'retailer'=>$req->retailer,
                        'supplier'=>$req->supplier,
                        'item' => $item,
                        'nop' => $req->pieces[$key],
                        'weight' => $req->weight[$key],
                        'services' => $req->service[$key],
                        'client_id' =>$client_unique_id[0]->client_id,
                    ]);
                    $processedItemIds[] = $newItem->conf_item;
                }
            }
    
            // Delete unprocessed items
            confirmitemstables::where('confirmid', $req->client_ids)
                ->whereNotIn('conf_item', $processedItemIds)
                ->delete();
    
            DB::commit();
            return back()->with('success', 'Data saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
        
        
        
             
        
         }
        
            
       
         public function deleteItem($id)
         {
             try {
                 $item = confirmitemstables::where('conf_item', $id)->first();
         
                 if ($item) {
                     $item->delete();
                     return response()->json(['message' => 'Item deleted successfully.']);
                 } else {
                     return response()->json(['message' => 'Item not found.'], 404);
                 }
             } catch (\Exception $e) {
                 return response()->json(['message' => 'Failed to delete item.'], 500);
             }
         }


     

     public function confirmEntryStore(Request $req){
      
        $validator = Validator::make($req->all(), [
            'depname' => 'required|string',
            'logo' => 'required',
            'DepositorName' => 'required|string',
            'ReceiverName' => 'required|string',
            'InvoiceDate' => 'required|date',
            'Deliverydate' => 'required|date',

            'item' => 'required|array',
            'item.*' => 'required|string|in:Jewellery,Loose diamond,Gem Stone,CVD', // Validating each item in the array
            'pieces' => 'required|array',
            'pieces.*' => 'required|numeric|min:1', // Ensure each piece is a number greater than 0
            'weight' => 'required|array',
            'weight.*' => 'required|numeric|min:0', // Ensure each weight is a number (can be 0)
            'service' => 'required|array',
            'service.*' => 'required|numeric|exists:services,service_id',
        ], [
            'depname.required' => 'Client Name Required',
          
        ]);
    
        if ($validator->fails()) {
            // Redirect back with input and validation errors
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validation failed! Please check the inputs.')
                ->withInput();
        }

        $currentDate = Carbon::now();
        $year = $currentDate->year;
        $month = $currentDate->month;
        $financialYearStart = ($month < 4) ? $year - 1 : $year;
        $financialYearCode = substr($financialYearStart, -2); // Get last two digits, e.g., 24 for 2024
        $lastEntry = Confirmentrys::orderBy('conf_id', 'desc')->first();
        $lastEntry1 = confirmitemstables::orderBy('conf_item', 'desc')->first();
        $lastId = $lastEntry ? $lastEntry->conf_id : 0;     
        $lastId1 = $lastEntry1 ? $lastEntry1->conf_item : 0;     

        $confirmId = 'GIL' . $financialYearCode . 'CNF' . $lastId+1;
        $confirmId1 = 'GIL' . $financialYearCode . 'CNF' . $lastId1+1;

        

       

        DB::beginTransaction();

        try {
    // Insert into first table
            $confirmentrys = confirmentrys::create([
                'confirmationid' => $confirmId,
                'client_id' => $req->client_id,
                'depositer_name' => $req->DepositorName,
                'depositor_add' => $req->client_address,
                'gstno' => $req->clinet_gst,
                'city' => $req->client_city,
                'country' => $req->client_country,
                'reciever' => $req->ReceiverName,
                'deliverydate' => $req->Deliverydate,
                'invoicedate' => $req->InvoiceDate,
                'company_logo' => $req->logo,
                'active' => "1",
            ]);

          

    // Loop through the items array and insert into second table
            foreach ($req->item as $key => $item) {
                confirmitemstables::create([
                    'confirmid' => $confirmentrys->confirmationid,
                    'retailer' => $req->retailer,
                    'supplier' => $req->supplier,
                    'item' => $item, // Get item value by index
                    'nop' => $req->pieces[$key], // Corresponding no. of pieces
                    'weight' => $req->weight[$key], // Corresponding weight
                    'services' => $req->service[$key], // Corresponding service
                    'client_id' =>$req->client_id, // Corresponding service
                ]);
            }

                // If everything is fine, commit the transaction
                DB::commit();

                // Return success message or redirect
                return back()->with('success', 'Data saved successfully!');
            } catch (\Exception $e) {
                // If there's an error, rollback the transaction
                DB::rollBack();

                // Log the error (optional)
                \Log::error($e->getMessage());

                // Return error message or redirect
                return back()->with('error', 'Failed to save data. Please try again.');
            }



     

     }



 }
