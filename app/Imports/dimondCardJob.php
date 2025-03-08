<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\cuttables;
use App\Models\djobcardtables;
use Maatwebsite\Excel\Concerns\ToModel;



use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class dimondCardJob implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $index => $row) {

         
            if ($index === 0) {
                continue; // Skip the header row if needed
            }
            
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue; // Skip completely empty rows
            }
            // Check if the row is not empty
            // if (empty($row[0]) || empty($row[1]) || empty($row[2])|| empty($row[3]) || empty($row[4]) || 
            //     empty($row[5])|| empty($row[6]) || empty($row[7]) || empty($row[8])|| empty($row[9]) ||
            //      empty($row[10]) || empty($row[11])|| empty($row[12]) || empty($row[13]) || empty($row[14])|| empty($row[15]) ) {
            //     continue; // Skip empty or invalid rows
               
            // }
          

            $cutCode=cuttables::where('code',$row[2])->value('cut_id');
            $clarity=claritys::where('Clarity',$row[6])->value('calrity_id');
            $color_code=colourtables::where('color_code',$row[7])->value('color_id');
            
            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(100, 999);
            $brand = "GILHJ" . $uniqueNumber;

            // Insert data into the database
            // dd($row[0]);
            try {
            djobcardtables::create([
                'confirmid' =>  $row[0],
                'djobcardid' => $brand,
                'service' => $row[1],
                'dia' => $die,
                'nop' => $row[4],
                'cut' => $cutCode ?? null,
                'carat' => $row[3] ?? null,
                'measure' =>  $row[5] ?? null,
                'clarity' => $clarity ?? null,
                'color' => $color_code ?? null,
                'florosense' => $row[8] ?? null,
                'finish' => $row[9] ?? null,
                'tble' => $row[10] ?? null,
                'crown' => $row[11] ?? null,
                'pavilion' => $row[12] ?? null,
                'culet' => $row[13] ?? null,
                'girdle' => $row[14] ?? null,
                'big_d' => $row[15] ?? 0,
               
               
            ]);
            } catch (\Exception $e) {
                dd($e->getMessage()); // Debug SQL errors
            }
        }

    }
}
