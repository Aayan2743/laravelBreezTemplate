<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmentrys extends Model
{
    use HasFactory;

    public $table="confirmentry";

    public $timestamps=false;

    protected $guarded=[];
}
