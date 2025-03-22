<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_extracharges extends Model
{
    use HasFactory;

    public $table="invoice_extracharge";

    public $timestamps=false;

    protected $guarded=[];

    public function serviceName()
    {
        return $this->belongsTo(servicetype::class, 'service','servicetypes_id'); // Assuming clarity_id is the foreign key
    }
}
