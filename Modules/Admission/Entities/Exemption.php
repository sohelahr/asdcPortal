<?php

namespace Modules\Admission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admission\Entities\Admission;

class Exemption extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Admission\Database\factories\ExemptionFactory::new();
    }

    function Admission(){
        return $this->belongsTo(Admission::class);
    }
}
