<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobcardtables extends Model
{
    use HasFactory;

    // protected $primaryKey = 'conf_item';

    public $table="jobcardtable";

    public $timestamps=false;

    protected $guarded=[];
}
