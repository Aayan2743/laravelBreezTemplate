<?php

namespace App\Http\Controllers;
use App\Models\cuttables;
use Illuminate\Http\Request;

class Cuttable extends Controller
{
  
    public function index()
    {
        $data=cuttables::get();
        return view('cut',compact('data'));
    }

  
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {

       
        $createColor=cuttables::create([
            'cutname'=>$request->cutname,
            'code'=>$request->code,
            
        ]);

        if($createColor){
            return redirect()->back()->with('success', 'Cut  Entry Added successfully!');
        }else{
            return redirect()->back()->with('error', 'Cut  Not Added successfully!');
        }
    }

    
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        $jobcardtables=cuttables::where('cut_id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Cut Name deleted successfully!');
    }

    public function updateDetails(Request $request)
    {
       

        $updateColorCode=cuttables::where('cut_id',$request->cut_id)->update([
            'cutname'=>$request->cutnames,
            'code'=>$request->codes
        ]);

         if($updateColorCode){
            return redirect()->back()->with('success', 'Cut Name Updated successfully!');
         }else{
            return redirect()->back()->with('error', 'Cut Name Not Updated successfully!');
         }   
    }
}
