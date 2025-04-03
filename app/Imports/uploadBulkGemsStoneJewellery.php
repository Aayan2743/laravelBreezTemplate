<?php

namespace App\Imports;

use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\itemtables;
use App\Models\colourtables;
use App\Models\cuttables;
use App\Models\cjobcardtables;
use App\Models\gemstonejobcardtabs;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\confirmentrys;



class uploadBulkGemsStoneJewellery implements ToCollection
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
            if (empty($row[0]) || empty($row[1]) || empty($row[2])|| empty($row[3])) {

              
                continue; // Skip empty or invalid rows
            }


            if (cjobcardtables::where('jobcardid', $row[1])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            // Check if confirmation entry exists
            if (!confirmentrys::where('confirmationid', $row[0])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(1000, 9999);
            $brand = "GILHJ" . $uniqueNumber;
           // dd($brand);
            // Insert data into the database
            $sss=cjobcardtables::create([
                'jobcardid' => $row[1],
                'confirmid' => $row[0],
                'service' => 'Gemstones-Loose&Studded',
                'dia' => $die,
                'item' => itemtables::where('item_name', $row[2])->value('item_id') ?? null,
                'grwt' => $row[3] ?? null,
                'estwt' => $row[4] ?? null,
                'metal' => metals::where('code', $row[6])->value('metal_id') ?? null,
                // 'calrity' => claritys::where('Clarity', $row[7])->value('calrity_id') ?? null,
                // 'color' => colourtables::where('color_code', $row[8])->value('color_id') ?? null,
                'cut' => cuttables::where('code', $row[7])->value('cut_id') ?? null,
                'conc' => $row[5] ?? null,
                'conc1' => $row[8] ?? null,
            ]);

            $this->totalInserted++;

            // dd($sss);
        }    

        session()->flash('totalRecords', max(0, $this->totalInserted+$this->totalSkipped));
        session()->flash('totalInserted', $this->totalInserted);
        session()->flash('totalSkipped', $this->totalSkipped);


    }
}
