<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\servicetype;

class ratecards extends Model
{
    use HasFactory;

    public $table="ratecard";

    public $timestamps=false;

    protected $guarded=[];
// servicetype_id
// servicetypes_id
    public function serviceTypess()
        {
            return $this->belongsTo(servicetype::class, 'servicetype_id','servicetypes_id');
            // return $this->belongsTo(Servicetypes::class, 'servicetype_id', 'servicetypes_id');
        
        }

        public function getServiceTypessAttribute() {
            return $this->serviceType; // or however you're setting it
        } 
}
