<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuttables extends Model
{
    use HasFactory;
    public $table="cuttable";

    public $timestamps=false;

    protected $guarded=[];
}
