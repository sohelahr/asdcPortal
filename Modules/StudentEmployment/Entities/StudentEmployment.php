<?php

namespace Modules\StudentEmployment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admission\Entities\Admission;

class StudentEmployment extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\StudentEmployment\Database\factories\StudentEmploymentFactory::new();
    }

    public function Admission(){
        return $this->belongsTo(Admission::class);
    }
    function Student(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    function Course(){
        return $this->hasOne(Course::class,'id','course_id');
    }
}
