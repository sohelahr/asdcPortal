<?php

namespace Modules\CourseBatch\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admission\Entities\Admission;
use Modules\Course\Entities\Course;
use Modules\Registration\Entities\Registration;

class CourseBatch extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\CourseBatch\Database\factories\CourseBatchFactory::new();
    }

    function Course(){
        return $this->belongsTo(Course::class);
    }
    
    public function Admissions(){
        return $this->hasMany(Admission::class,'coursebatch_id');
    }
    function BatchSlots(){
        return $this->hasMany(BatchSlotTransaction::class,'batch_id');
    }
}
