<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\state;
use App\Models\citie;
use App\Models\service;
use App\Models\clientinformationDetails;
use App\Models\clientcompanylogoData;
// use validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    //

    public function add_clientinformation(Request $req){

        // $validator=Validator::make($req->all(),[
        //     'depname'=>'required|string',
        //     'mobile'=>'required|digits:10',

        // ],[
        //     'depname.required'=>'Client Name Required',
        //     'mobile.required'=>'Mobile No Required',
        //     'mobile.digits'=>'Mobile No Allowed Only digits',
        // ]);

        // if ($validator->fails()) {
        //     // Redirect back with input and validation errors
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
       
        // $create_order=clientinformationDetails::create([
        //         'client_name'=>$req->depname,
        //         'address'=>$req->depadd,
        //         'retailer'=>$req->retailer,
        //         'supplier'=>$req->supplier,
        //         'depositorname'=>$req->depositor,
        //         'phonenumber'=>$req->mobile,
        //         'email'=>$req->email,
        //         'panno'=>$req->panno,
        //         'tanno'=>$req->tanno,
        //         'gstno'=>$req->gstno,
        //         'state'=>$req->state,
        //         'city'=>$req->city,
        //         'country'=>'India',
        //         'other_city'=>$req->ancity,
        //         'dj1'=>$req->rate1,
        //         'dj2'=>$req->rate2,
        //         'sdj1'=>$req->rate3,
        //         'sdj2'=>$req->rate4,

        //         'dg1'=>$req->rate5,
        //         'dg2'=>$req->rate6,
        //         'sdg1'=>$req->rate7,
        //         'sdg2'=>$req->rate8,
        //         'gls1'=>$req->rate9,
        //         'gls2'=>$req->rate10,
        //         'gls3'=>$req->rate11,
        //         'gls4'=>$req->rate12,
        //         //'cvd1'=>$req->rate14,
        //         'cvd2'=>$req->rate14,
        //         'cvd3'=>$req->rate15,
        //         'cvd4'=>$req->rate16,

        //         'un1'=>$req->rate17,
        //         'un2'=>$req->rate18,
        //         'carat1'=>$req->carat1,
        //         'carat2'=>$req->carat2,
        //         'carat3'=>$req->carat3,
        //         'carat4'=>$req->carat4,
        //         'carat5'=>$req->carat5,
        //         'carat6'=>$req->carat6,
        //         'carat7'=>$req->carat7,
        //         'carat8'=>$req->carat8,
        //         'carat9'=>$req->carat9,
        //         'carat10'=>$req->carat10,
        //         'carat11'=>$req->carat11,
        //         'carat12'=>$req->carat12,
        //          'carat13'=>$req->depname,
        //         'carat14'=>$req->carat14,
        //         'carat15'=>$req->carat15,
        //         'carat16'=>$req->carat16,
        //         'carat17'=>$req->carat17,
        //         'carat18'=>$req->carat18,
        //         // 'crdate'=>$req->depname,
        //         // 'status'=>$req->depname,



        // ]);

        // dd($create_order);


        $validator = Validator::make($req->all(), [
            'depname' => 'required|string',
            'mobile' => 'required|digits:10',
        ], [
            'depname.required' => 'Client Name Required',
            'mobile.required' => 'Mobile No Required',
            'mobile.digits' => 'Mobile No Allowed Only digits',
        ]);
    
        if ($validator->fails()) {
            // Redirect back with input and validation errors
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validation failed! Please check the inputs.')
                ->withInput();
        }
    
        // try {
        //     $create_order = clientinformationDetails::create([
        //         'client_name' => $req->depname,
        //         'address' => $req->depadd,
        //         'retailer' => $req->retailer,
        //         'supplier' => $req->supplier,
        //         'depositorname' => $req->depositor,
        //         'phonenumber' => $req->mobile,
        //         'email' => $req->email,
        //         'panno' => $req->panno,
        //         'tanno' => $req->tanno,
        //         'gstno' => $req->gstno,
        //         'state' => $req->state,
        //         'city' => $req->city,
        //         'country' => 'India',
        //         'other_city' => $req->ancity,
        //         'dj1' => $req->rate1,
        //         'dj2' => $req->rate2,
        //         'sdj1' => $req->rate3,
        //         'sdj2' => $req->rate4,
        //         'dg1' => $req->rate5,
        //         'dg2' => $req->rate6,
        //         'sdg1' => $req->rate7,
        //         'sdg2' => $req->rate8,
        //         'gls1' => $req->rate9,
        //         'gls2' => $req->rate10,
        //         'gls3' => $req->rate11,
        //         'gls4' => $req->rate12,
        //         'cvd2' => $req->rate14,
        //         'cvd3' => $req->rate15,
        //         'cvd4' => $req->rate16,
        //         'un1' => $req->rate17,
        //         'un2' => $req->rate18,
        //         'carat1' => $req->carat1,
        //         'carat2' => $req->carat2,
        //         'carat3' => $req->carat3,
        //         'carat4' => $req->carat4,
        //         'carat5' => $req->carat5,
        //         'carat6' => $req->carat6,
        //         'carat7' => $req->carat7,
        //         'carat8' => $req->carat8,
        //         'carat9' => $req->carat9,
        //         'carat10' => $req->carat10,
        //         'carat11' => $req->carat11,
        //         'carat12' => $req->carat12,
        //         'carat13' => $req->depname,
        //         'carat14' => $req->carat14,
        //         'carat15' => $req->carat15,
        //         'carat16' => $req->carat16,
        //         'carat17' => $req->carat17,
        //         'carat18' => $req->carat18,
        //     ]);
    
        //     return redirect()->back()->with('success', 'Client information added successfully!');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Failed to add client information. Please try again.');
        // }

        // dd($req->client_id);
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


    



    public function create(){

        $states=state::where('country_id',100)->get();
        

        return view('addCustomer',compact('states'));
    }

    public function viewClients(Request $request){
        
        // $clientinformation=clientinformationDetails::paginate(8);
        // return view('viewClients',compact('clientinformation'));

        // $query = clientinformationDetails::query();
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



 }
