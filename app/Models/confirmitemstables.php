<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmitemstables extends Model
{
    use HasFactory;
    protected $primaryKey = 'conf_item';

    public $table="confirmitemstable";

    public $timestamps=false;

    protected $guarded=[];

    public function client_details()
    {
        return $this->belongsTo(clientinformationDetails::class, 'client_id','client_id'); // Assuming metal_id is the foreign key
    }

    public function confirmEntryDetails()
    {
        return $this->belongsTo(confirmentrys::class, 'client_id','client_id'); // Assuming metal_id is the foreign key
    }

    public function serviceDetails()
    {
        return $this->belongsTo(servicesList::class, 'services','service_id'); // Assuming metal_id is the foreign key
    }
}
