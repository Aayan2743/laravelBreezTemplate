<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicetype extends Model
{
    use HasFactory;
    public $table="servicetypes";

    public $timestamps=false;

    protected $guarded=[];

    public function ratecards()
        {
            return $this->hasMany(ratecards::class, 'servicetype_id');
        }
}
