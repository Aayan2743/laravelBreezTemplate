<?php

namespace App\Http\Controllers;
use App\Models\colourtables;

use Illuminate\Http\Request;

class ColorController extends Controller
{
  
    public function index()
    {
        $data=colourtables::get();
     return view('colors',compact('data'));

    }

  
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
            $createColor=colourtables::create([
                'color_code'=>$request->color_code
            ]);

            if($createColor){
                return redirect()->back()->with('success', 'Color  Entry Added successfully!');
            }else{
                return redirect()->back()->with('error', 'Color  Not Added successfully!');
            }
    }

   
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        
    }

 
    public function update(Request $request, $id)
    {
        //
    }

    public function updateDetails(Request $request)
    {
        // dd($request->all());

        $updateColorCode=colourtables::where('color_id',$request->color_id)->update([
            'color_code'=>$request->color_codes
        ]);

         if($updateColorCode){
            return redirect()->back()->with('success', 'Color Name Updated successfully!');
         }else{
            return redirect()->back()->with('error', 'Color Name Not Updated successfully!');
         }   
    }


  
    public function destroy($id)
    {

    
        $jobcardtables=colourtables::where('color_id',$id)->delete();
       
        
        // $clientinformation->delete();

        return redirect()->back()->with('success', 'Color Name deleted successfully!');


    }
}
