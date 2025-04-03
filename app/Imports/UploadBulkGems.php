<?php

namespace App\Imports;

use App\Models\jobcardtables;
use App\Models\confirmentrys;
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

         private $totalRecords = 0;
        private $totalInserted = 0;
        private $totalSkipped = 0;
    public function collection(Collection $rows)
    {   

        $this->totalRecords = $rows->count() - 1;

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Skip the header row if needed
            }

            // Check if the row is not empty
            if (empty($row[0]) || empty($row[6]) || empty($row[7])|| empty($row[8])  ) {
                $this->totalSkipped++;
                continue; // Skip empty or invalid rows
            }

            if (gemstonejobcardtabs::where('gjobcardid', $row[1])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            // Check if confirmation entry exists
            if (!confirmentrys::where('confirmationid', $row[0])->exists()) {
                $this->totalSkipped++;
                continue;
            }



            $shapes=cuttables::where('code',$row[4])->value('cut_id');
           
            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(100, 999);
            $brand = "GILHJ" . $uniqueNumber;

            // Insert data into the database
            gemstonejobcardtabs::create([
                'gjobcardid' => $row[1],
                'service' => 'Gemstones-Loose&Studded',
                'confirmid' => $row[0],
                'species' => $row[2],
                'dia' => $die,
                'variety' => $row[3],
                'shape' => $shapes ?? null,
                'carat' => $row[5] ?? null,
                'measure' =>  $row[6] ?? null,
                'transperancy' => $row[7] ?? null,
                'refindex' => $row[8] ?? null,
                'comments' => $row[9] ?? null,
               
            ]);
            $this->totalInserted++;
        }
        session()->flash('totalRecords', max(0, $this->totalInserted+$this->totalSkipped));
        session()->flash('totalInserted', $this->totalInserted);
        session()->flash('totalSkipped', $this->totalSkipped);
    }
}
