<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\state;
use App\Models\citie;
use App\Models\clientinformationDetails;
// use validator;
use Illuminate\Support\Facades\Validator;

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
    
        try {
            $create_order = clientinformationDetails::create([
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
            ]);
    
            return redirect()->back()->with('success', 'Client information added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add client information. Please try again.');
        }
        
       

    }


    public function create(){

        $states=state::where('country_id',100)->get();
        

        return view('addCustomer',compact('states'));
    }

    public function getCities(Request $request)
    {

        //dd($request->state_id);
        $cities = citie::where('state_id', $request->state_id)->get(); // Fetch cities by state_id
        return response()->json($cities); // Return JSON response
    }

}
