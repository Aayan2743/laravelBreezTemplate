<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cuttables;
use App\Models\gemstonejobcardtabs;
use App\Models\cjobcardtables;
use App\Imports\UploadBulkGems;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class GemsJeweleryCardController extends Controller
{
    
    public function index(Request $request){

        $query = cjobcardtables::orderBy('jobcard_id', 'desc');

        if ($request->has('search')) {
            $query->where('confirmid', 'like', '%' . $request->search . '%');
                
        }
    
        $clientinformation = $query->paginate(8);

        // dd($clientinformation);
    
        if ($request->ajax()) {
            return view('partials.client_table_diamondCard', compact('clientinformation'))->render();
        }
    
        return view('uploadDiamondCardJob', compact('clientinformation'));
        // return view('uploads');
    }

}
