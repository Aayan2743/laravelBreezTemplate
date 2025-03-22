<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmentrys extends Model
{
    use HasFactory;
    // protected $primaryKey = 'conf_id';

    public $table="confirmentry";

    public $timestamps=false;

    protected $guarded=[];

    // public func

    // protected $hidden = ['created_at', 'updated_at'];

    // public function client_details()
    // {
    //     return $this->belongsTo(clientinformationDetails::class, 'client_id','client_id'); // Assuming metal_id is the foreign key
    // }
    public function client_details()
    {
        return $this->hasOne(clientinformationDetails::class, 'client_id', 'client_id'); 
    }


    public function diamond_jobs()
    {
        // return $this->belongsTo(jobcardtables::class, 'confirmationid','confirmid'); // Assuming metal_id is the foreign key
        return $this->hasMany(jobcardtables::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
        // return $this->hasMany(jobcardtables::class, 'confirmationid','confirmid'); // Assuming metal_id is the foreign key
    }

   
    public function gemstone_jobs()
    {
        return $this->hasMany(gemstonejobcardtabs::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
    }

    public function diamonds_card_jobs()
    {
        return $this->hasMany(djobcardtables::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
    }


    public function gem_jewellery_card_jobs()
    {
        return $this->hasMany(cjobcardtables::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
    }

    public function uncut_jewellery_card()
    {
        return $this->hasMany(uncutcardtables::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
    }

    public function extraCharges()
    {
        return $this->hasMany(invoice_extracharges::class, 'confirmid','confirmationid'); // Assuming metal_id is the foreign key
    }


    // djobcardtable
}
