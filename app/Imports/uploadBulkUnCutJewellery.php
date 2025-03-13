<?php

namespace App\Imports;

use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\itemtables;
use App\Models\colourtables;
use App\Models\cuttables;
use App\Models\cjobcardtables;
use App\Models\ununcutcardtables;
use App\Models\gemstonejobcardtabs;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;




class uploadBulkGemsStoneJewellery implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
      

        foreach ($rows as $index => $row) {
            if ($index === 0) {
             
                continue; // Skip the header row if needed
              
            }

            // Check if the row is not empty
            if (empty($row[0]) || empty($row[1]) || empty($row[2])|| empty($row[3]) || empty($row[4])  || empty($row[5]) || empty($row[6]) || empty($row[7]) || empty($row[8])  ) {

              
                continue; // Skip empty or invalid rows
            }

            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(1000, 9999);
            $brand = "GILHJ" . $uniqueNumber;
           // dd($brand);
            // Insert data into the database
            $sss=ununcutcardtables::create([
                'jobcardid' => $brand,
                'confirmid' => $row[0],
                'service' => 'Uncut Jewellery',
                'dia' =>$row[8],
                'item' => $row[1],
                'grwt' => $row[2] ?? null,
                'estwt' => $row[3] ?? null,
                'metal' => metals::where('code', $row[6])->value('metal_id') ?? null,
                // 'calrity' => claritys::where('Clarity', $row[7])->value('calrity_id') ?? null,
                // 'color' => colourtables::where('color_code', $row[8])->value('color_id') ?? null,
                'cut' => cuttables::where('code', $row[7])->value('cut_id') ?? null,
                'nol' => $row[4] ?? null,
               
            ]);

            // dd($sss);
        }    


    }
}
