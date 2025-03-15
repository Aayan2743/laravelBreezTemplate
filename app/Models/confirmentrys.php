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

    public function client_details()
    {
        return $this->belongsTo(clientinformationDetails::class, 'client_id','client_id'); // Assuming metal_id is the foreign key
    }
}
