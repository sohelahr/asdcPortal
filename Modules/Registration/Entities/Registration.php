<?php

namespace Modules\Registration\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;
use Modules\CourseSlot\Entities\CourseSlot;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Registration\Database\factories\RegistrationFactory::new();
    }

    function Course(){
        return $this->hasOne(Course::class,'id','course_id');
    }
    function CourseSlot(){
        return $this->hasOne(CourseSlot::class,'id','course_slot_id');
    }
    function Student(){
        return $this->belongsTo(User::class,'student_id','id');
    }
}
