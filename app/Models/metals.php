<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metals extends Model
{
    use HasFactory;

    public $table="metal";

    public $timestamps=false;

    protected $guarded=[];
}
