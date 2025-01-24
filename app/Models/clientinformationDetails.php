<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientinformationDetails extends Model
{
    use HasFactory;

    protected $table = 'clientinformation';

    // Primary key
    protected $primaryKey = 'client_id';

    // Disable timestamps (created_at, updated_at)
    public $timestamps = false;

    // Allow mass assignment for all attributes
    protected $guarded = [];


}
