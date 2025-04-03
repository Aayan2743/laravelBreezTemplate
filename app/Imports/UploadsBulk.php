<?php

namespace App\Imports;
// jobcardtables
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
use App\Models\confirmentrys;
use App\Models\cuttables;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\HeadingRow\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UploadsBulk implements ToCollection
{
    private $totalRecords = 0;
    private $totalInserted = 0;
    private $totalSkipped = 0;

    public function collection(Collection $rows)
    {
        // $this->totalRecords = count($rows) - 1; // Exclude header row
        $this->totalRecords = $rows->count() - 1;

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Skip header row
            }

            // Check if required fields are empty
            if (empty($row[0]) || empty($row[6]) || empty($row[7]) || empty($row[8])) {
                // $this->totalSkipped++;
                continue;
            }

            // Check if jobcard already exists
            if (jobcardtables::where('jobcardid', $row[1])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            // Check if confirmation entry exists
            if (!confirmentrys::where('confirmationid', $row[0])->exists()) {
                $this->totalSkipped++;
                continue;
            }

            // Insert Data
            jobcardtables::create([
                'jobcardid' => $row[1],
                'confirmid' => $row[0],
                'service' => $row[2],
                'dia' => rand(1000, 9999),
                'item' => $row[3],
                'grwt' => $row[4] ?? null,
                'estwt' => $row[5] ?? null,
                'metal' => metals::where('code', $row[7])->value('metal_id') ?? null,
                'calrity' => claritys::where('Clarity', $row[8])->value('calrity_id') ?? null,
                'color' => colourtables::where('color_code', $row[9])->value('color_id') ?? null,
                'cut' => cuttables::where('code', $row[10])->value('cut_id') ?? null,
                'nol' => $row[6] ?? null,
                'big_j' => $row[11] ?? null,
            ]);

            $this->totalInserted++;
        }

        // Store counts in session
        // session()->flash('totalRecords', $this->totalRecords);
        session()->flash('totalRecords', max(0, $this->totalInserted+$this->totalSkipped));
        session()->flash('totalInserted', $this->totalInserted);
        session()->flash('totalSkipped', $this->totalSkipped);
    }
}


