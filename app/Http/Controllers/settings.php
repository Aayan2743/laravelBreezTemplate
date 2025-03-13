<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\claritys;

class settings extends Controller
{
    //

    public function clarityindex(){

        $clarityData=claritys::get();
        return view('clarity',compact('clarityData'));

    }

    public function clarity_update(Request $req){

        $updateClarityName=claritys::where('calrity_id',$req->calrity_id)->update([
            'Clarity'=>$req->Claritys

        ]);


       // dd($updateClarityName);

        if($updateClarityName){
            return redirect()->back()->with('success', 'Clarity  Entry Updated successfully!');
        }else{
            return redirect()->back()->with('error', 'Clarity  Not Updated successfully!');
        }

    }

    public function store_clarity(Request $req){

        $storeClarity=claritys::create([
            'Clarity'=>$req->Clarity
        ]);

        if($storeClarity){
            return redirect()->back()->with('success', 'Clarity  Entry Added successfully!');
        }else{
            return redirect()->back()->with('error', 'Clarity  Not Added successfully!');
        }
        
    }

    public function clarity_delete($id){
        //dd($id);
        $jobcardtables=claritys::where('calrity_id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'clarity Name deleted successfully!');
        // dd($clientinformation);
    }


}
