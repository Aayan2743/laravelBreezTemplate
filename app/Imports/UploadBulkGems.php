<?php

namespace App\Imports;

use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\cuttables;
use App\Models\gemstonejobcardtabs;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;




class UploadBulkGems implements ToCollection
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
            if (empty($row[0]) || empty($row[6]) || empty($row[7])|| empty($row[8])) {
                continue; // Skip empty or invalid rows
            }

            $shapes=cuttables::where('code',$row[3])->value('cut_id');
           
            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(100, 999);
            $brand = "GILHJ" . $uniqueNumber;

            // Insert data into the database
            gemstonejobcardtabs::create([
                'gjobcardid' => $brand,
                'service' => 'Gemstones-Loose&Studded',
                'confirmid' => $row[0],
                'species' => $row[1],
                'dia' => $die,
                'variety' => $row[2],
                'shape' => $shapes ?? null,
                'carat' => $row[4] ?? null,
                'measure' =>  $row[5] ?? null,
                'transperancy' => $row[6] ?? null,
                'refindex' => $row[7] ?? null,
                'comments' => $row[8] ?? null,
               
            ]);
        }
    }
}
