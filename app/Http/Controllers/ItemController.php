<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\itemtables;

class ItemController extends Controller
{
    //
    public function itemIndex(){

        $data=itemtables::get();
        return view('items',compact('data'));

    }

    public function item_update(Request $req){

        $updateClarityName=itemtables::where('item_id',$req->item_id)->update([
            'item_name'=>$req->item_name,
            'item_code'=>$req->item_code

        ]);


       // dd($updateClarityName);

        if($updateClarityName){
            return redirect()->back()->with('success', 'Item  Entry Updated successfully!');
        }else{
            return redirect()->back()->with('error', 'Item  Not Updated successfully!');
        }

    }

    public function store_item(Request $req){

        $storeClarity=itemtables::create([
            'item_name'=>$req->item_name,
            'item_code'=>$req->item_code,
            'active'=>1,
        ]);

        if($storeClarity){
            return redirect()->back()->with('success', 'Item  Entry Added successfully!');
        }else{
            return redirect()->back()->with('error', 'Item  Not Added successfully!');
        }
        
    }

    public function item_delete($id){
        //dd($id);
        $jobcardtables=itemtables::where('item_id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Item Name deleted successfully!');
        // dd($clientinformation);
    }


}
