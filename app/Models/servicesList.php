<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicesList extends Model
{
    use HasFactory;

    public $table="services";

    public $timestamps=false;

    protected $guarded=[];

}
