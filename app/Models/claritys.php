<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class claritys extends Model
{
    use HasFactory;

    public $table="clarity";

    public $timestamps=false;

    protected $guarded=[];
}
