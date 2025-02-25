<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\servicesList;

class servicesController extends Controller
{
    //
    public function list(){

       $servicesList=servicesList::get();
    
        return view('servicesList',compact('servicesList'));


    }

    public function listserviceUpdate(Request $req){




        $updatedata=servicesList::where('service_id',$req->serviceIddata)->update([
            'service_name'=>$req->serviceNameTxt
        ]);

        if( $updatedata){
            return back()->with('success', 'Service List Updated successfully!');
        }


    }

    public function listserviceStore(Request $req){

      

        $createService=servicesList::create([
        'service_name'=>$req->serviceName,
        'active'=>'1'
        ]);

       // dd($createService);

        if( $createService){
            return back()->with('success', 'Service List Added successfully!');
        }

    }

}
