<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UploadsBulk;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\cuttables;

class uploadsControllers extends Controller
{
    //
    public function index(Request $request){

        $query = jobcardtables::orderBy('jobcard_id', 'desc');

        if ($request->has('search')) {
            $query->where('confirmid', 'like', '%' . $request->search . '%');
                
        }
    
        $clientinformation = $query->paginate(8);

        // dd($clientinformation);
    
        if ($request->ajax()) {
            return view('partials.client_table_jobcard', compact('clientinformation'))->render();
        }
    
        return view('uploads', compact('clientinformation'));
        // return view('uploads');
    }


    public function import(Request $request){

        // dd($request->all());

        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ]);

        Excel::import(new UploadsBulk, $request->file('file'));

        return back()->with('success', 'Excel file imported successfully!');
    }

    public function viewDiamondJewellery (Request $request){
        
    
        $query = jobcardtables::orderBy('jobcard_id', 'desc');

        if ($request->has('search')) {
            $query->where('confirmid', 'like', '%' . $request->search . '%');
                
        }
    
        $clientinformation = $query->paginate(8);

        dd($clientinformation);
    
        if ($request->ajax()) {
            return view('partials.client_table_jobcard', compact('clientinformation'))->render();
        }
    
        return view('uploads', compact('clientinformation'));


    }

}
