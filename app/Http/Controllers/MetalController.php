<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\metals;

class MetalController extends Controller
{
  
    public function index()
    {
        $data=metals::get();
        return view('metals',compact('data'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        // dd($request->all());
        $createColor=metals::create([
            'metal_name'=>$request->metal_name,
            'code'=>$request->code,
        ]);

        if($createColor){
            return redirect()->back()->with('success', 'Metal  Entry Added successfully!');
        }else{
            return redirect()->back()->with('error', 'Metal  Not Added successfully!');
        }
    }

    
    public function show($id)
    {
        //
    }

   function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        $jobcardtables=metals::where('metal_id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Metal Name deleted successfully!');
    }

    // Custom Functions

    public function updateDetails(Request $request)
    {
        //  dd($request->all());

        $updateColorCode=metals::where('metal_id',$request->metal_id)->update([
            'metal_name'=>$request->metal_names,
            'code'=>$request->codes
        ]);

         if($updateColorCode){
            return redirect()->back()->with('success', 'Color Name Updated successfully!');
         }else{
            return redirect()->back()->with('error', 'Color Name Not Updated successfully!');
         }   
    }
}
