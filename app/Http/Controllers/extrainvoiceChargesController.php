<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice_extracharges;
use App\Models\servicetype;
class extrainvoiceChargesController extends Controller
{
    //

    public function index(Request $req,$id){
       
        $get_charges=invoice_extracharges::with('serviceName')->where('confirmid',$id)->get();
       
        $servicetype=servicetype::get();
        $confirmationNo=$id;

        return view('invoiceChargesList',compact('get_charges','servicetype','confirmationNo'));

    }

    public function store(Request $req){
        $addAmount=invoice_extracharges::create([
            'confirmid'=>$req->confirmationNo,
            'service'=>$req->Service,
            'price'=>$req->Price,
            'extra_comment'=>$req->comments,
            'status'=>1
        ]);

        if($addAmount){
            return back()->with('success','Extra amount Added');
        }

    }

    public function update(Request $req){

        $update_details=invoice_extracharges::where('id',$req->uid)->update([
            'service'=>$req->Services,
            'price'=>$req->EPrice,
            'extra_comment'=>$req->Ecomments


        ]);

        return back()->with('success','Extra amount Updated');

    }


    public function delete($id){
        $jobcardtables=invoice_extracharges::where('id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Extra Charge deleted successfully!');
    }

}
