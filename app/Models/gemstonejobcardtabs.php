<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gemstonejobcardtabs extends Model
{
    use HasFactory;

    protected $primaryKey = 'gjobcard_id';

    public $table="gemstonejobcardtab";

    public $timestamps=false;

    protected $guarded=[];

    public function cutss()
    {
    return $this->belongsTo(cuttables::class, 'shape','cut_id'); // Assuming cut_id is the foreign key
    }

}
