<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cjobcardtables extends Model
{
    use HasFactory;

    protected $primaryKey = 'jobcard_id';

    public $table="cjobcardtable";

    public $timestamps=false;

    protected $guarded=[];

    public function metalss()
    {
        return $this->belongsTo(metals::class, 'metal','metal_id'); // Assuming metal_id is the foreign key
    }

    public function clarityss()
    {
        return $this->belongsTo(Claritys::class, 'clarity','calrity_id'); // Assuming clarity_id is the foreign key
    }

    public function colorss()
    {
        return $this->belongsTo(colourtables::class, 'color','color_id'); // Assuming color_id is the foreign key
    }

    public function cutss()
    {
    return $this->belongsTo(cuttables::class, 'cut','cut_id'); // Assuming cut_id is the foreign key
    }
}
