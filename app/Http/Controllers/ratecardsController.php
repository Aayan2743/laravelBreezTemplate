<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ratecards;
use DB;
class ratecardsController extends Controller
{
    //
    public function list(){

        // $rateCards=ratecards::get();

        $rateCards = Ratecards::with('serviceTypess')->get();

        $rateCards = DB::table('ratecard')
        ->join('servicetypes', 'ratecard.servicetype_id', '=', 'servicetypes.servicetypes_id')
        ->select('ratecard.*', 'servicetypes.servicetypes_names as service_type_name')
        ->get();


        // dd($rateCards);
        //  dd($rateCards);
        return view('rateCardList',compact('rateCards'));

    }

    public function updateratecard(Request $req){
            // dd($req->all());

            $updaterateCard=ratecards::where('ratecard_id',$req->serviceIddata)->update([
                'caratwt'=>$req->range,
                'wt'=>$req->weight,
                'rate'=>$req->rate,
                'ext'=>$req->ext,
            ]);

            if($updaterateCard){
                return back()->with('success', 'Rate Card Updated successfully!');
            }else{
                return back()->with('success', 'No Changes Happen');
            }
           

    }

}
