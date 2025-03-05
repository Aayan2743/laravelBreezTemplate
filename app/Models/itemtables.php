<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemtables extends Model
{
    use HasFactory;
    public $table="itemtable";

    public $timestamps=false;

    protected $guarded=[];
}
