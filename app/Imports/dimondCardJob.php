<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\jobid;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\cuttables;
use App\Models\djobcardtables;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\confirmentrys;



use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class dimondCardJob implements ToCollection
{
    /**
    * @param Collection $collection
    */
    private $totalRecords = 0;
    private $totalInserted = 0;
    private $totalSkipped = 0;    



    public function collection(Collection $rows)
    {
        //
        $this->totalRecords = $rows->count() - 1;
        foreach ($rows as $index => $row) {

         
            if ($index === 0) {
                continue; // Skip the header row if needed
            }
            
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue; // Skip completely empty rows
            }

            if (djobcardtables::where('djobcardid', $row[1])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            // Check if confirmation entry exists
            if (!confirmentrys::where('confirmationid', $row[0])->exists()) {
                $this->totalSkipped++;
                continue;
            }


         

        if (jobid::where('jobid', $row[1])->exists()) {
                        $this->totalSkipped++;
                        continue;
                    }
          
          

            $cutCode=cuttables::where('code',$row[3])->value('cut_id');
            $clarity=claritys::where('Clarity',$row[7])->value('calrity_id');
            $color_code=colourtables::where('color_code',$row[8])->value('color_id');
            
            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(100, 999);
            $brand = "GILHJ" . $uniqueNumber;

            // Insert data into the database
            // dd($row[0]);
            try {
            djobcardtables::create([
                'confirmid' =>  $row[0],
                'djobcardid' => $row[1],
                'service' => $row[2],
                'dia' => $die,
                'nop' => $row[5],
                'cut' => $cutCode ?? null,
                'carat' => $row[4] ?? null,
                'measure' =>  $row[6] ?? null,
                'clarity' => $clarity ?? null,
                'color' => $color_code ?? null,
                'florosense' => $row[9] ?? null,
                'finish' => $row[10] ?? null,
                'tble' => $row[11] ?? null,
                'crown' => $row[12] ?? null,
                'pavilion' => $row[13] ?? null,
                'culet' => $row[14] ?? null,
                'girdle' => $row[15] ?? null,
                'big_d' => $row[16] ?? 0,
               
               
            ]);

            jobid::create([
                'jobid' => $row[1],
                'confirm_id' => $row[0],
                'model'=>'djobcardtables'
                
            ]);



            $this->totalInserted++;
            } catch (\Exception $e) {
                dd($e->getMessage()); // Debug SQL errors
            }
           
        }

        session()->flash('totalRecords', max(0, $this->totalInserted+$this->totalSkipped));
        session()->flash('totalInserted', $this->totalInserted);
        session()->flash('totalSkipped', $this->totalSkipped);

    }
}
