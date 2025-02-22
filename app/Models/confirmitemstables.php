<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmitemstables extends Model
{
    use HasFactory;

    public $table="confirmitemstable";

    public $timestamps=false;

    protected $guarded=[];
}
