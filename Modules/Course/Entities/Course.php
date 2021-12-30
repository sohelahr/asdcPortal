<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admission\Entities\Admission;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Instructor\Entities\Instructor;
use Modules\Registration\Entities\Registration;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Course\Database\factories\CourseFactory::new();
    }
    
    public function CourseSlots(){
        return $this->hasMany(CourseSlot::class);
    }

    public function Instructors(){
        return $this->hasMany(Instructor::class);
    }

    public function CourseBatches(){
        return $this->hasMany(CourseBatch::class);
    }
    public function Registrations(){
        return $this->hasMany(Registration::class);
    }
    public function Admissions(){
        return $this->hasMany(Admission::class);
    }
}
