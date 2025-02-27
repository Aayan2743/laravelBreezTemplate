<?php

namespace App\Imports;
// jobcardtables
use App\Models\jobcardtables;
use App\Models\metals;
use App\Models\claritys;
use App\Models\colourtables;
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

            // Check if the row is not empty
            if (empty($row[0]) || empty($row[6]) || empty($row[7])|| empty($row[8])) {
                continue; // Skip empty or invalid rows
            }

            $die = rand(1000, 9999);
            $uniqueNumber = time() . rand(1000, 9999);
            $brand = "GILHJ" . $uniqueNumber;

            // Insert data into the database
            jobcardtables::create([
                'jobcardid' => $brand,
                'confirmid' => $row[0],
                'service' => $row[1],
                'dia' => $die,
                'item' => $row[2],
                'grwt' => $row[3] ?? null,
                'estwt' => $row[4] ?? null,
                'metal' => metals::where('code', $row[6])->value('metal_id') ?? null,
                'calrity' => claritys::where('Clarity', $row[7])->value('calrity_id') ?? null,
                'color' => colourtables::where('color_code', $row[8])->value('color_id') ?? null,
                'cut' => cuttables::where('code', $row[9])->value('cut_id') ?? null,
                'nol' => $row[5] ?? null,
                'big_j' => $row[10] ?? null,
            ]);
        }

    }

    // public function model(array $row)
    // {   

    //     $columnCount = count($row);

    //     // Debugging - Display the column count
    //     // dd($columnCount);
    
    //     // Stop processing if required columns are not present
    //     if ($columnCount < 13) {  // Adjust this number as needed
    //         return null;
    //     }

       
    //     // dd($row[3]);
    //     $rules = [
    //         '0'  => 'required',   // confirmid
    //         '1'  => 'required',   // service
    //         '2'  => 'required',   // item
    //         '3'  => 'required',           // grwt
    //         '4'  => 'required',           // estwt
    //         '5'  => 'nullable',           // nol
    //         '6'  => 'required',            // metal code
    //         '7'  => 'required',            // clarity
    //         '8' => 'required',            // color
    //         '9' => 'required',            // cut
    //         '10' => 'required',    // big_j
    //         '11' => 'required',    // big_j
    //         '12' => 'required',    // big_j
    //     ];   // Validate the row
    //     $validator = Validator::make($row, $rules);

    //     // Skip row if validation fails
    //     if ($validator->fails()) {

    //         dd("dfgkljdfjg",$validator->errors()->toArray());
    //         // Optional: Log or collect errors for review
    //         // logger()->error('Validation failed for row:', $validator->errors()->toArray());
    //         return null;
    //     }

    //     // Check foreign key constraints
    //     $metalId = metals::where('code', $row[8])->value('metal_id');
    //     $clarityId = claritys::where('Clarity', $row[9])->value('calrity_id');
    //     $colorId = colourtables::where('color_code', $row[10])->value('color_id');
    //     $cutId = cuttables::where('code', $row[11])->value('cut_id');

    //     if (!$metalId || !$clarityId || !$colorId || !$cutId) {
    //         // Skip row if any foreign key doesn't exist
    //         return null;
    //     }

    //     $die = rand(1000, 9999);
    //     $uniqueNumber = time() . rand(1000, 9999);
    //     $brand = "GILHJ" . $uniqueNumber;

    //     return new jobcardtables([
    //         'jobcardid' => $brand,
    //         'confirmid' => $row[0],
    //         'service' => $row[3],
    //         'dia' => $die,
    //         'item' => $row[4],
    //         'grwt' => $row[5],
    //         'estwt' => $row[6],
    //         'metal' => $metalId,
    //         'calrity' => $clarityId,
    //         'color' => $colorId,
    //         'cut' => $cutId,
    //         'nol' => $row[7] ?? null,  // Optional field
    //         'big_j' => $row[12],
    //     ]);
    // } 

       
}
