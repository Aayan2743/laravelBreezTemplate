<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colourtables extends Model
{
    use HasFactory;
    public $table="colourtable";

    public $timestamps=false;

    protected $guarded=[];
}
