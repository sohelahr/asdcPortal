<?php

namespace Modules\CourseSlot\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admission\Entities\Admission;
use Modules\Registration\Entities\Registration;

class CourseSlot extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\CourseSlot\Database\factories\CourseSlotFactory::new();
    }
    public function Course(){
        return $this->belongsTo(Course::class);
    }
    
    public function Registrations(){
        return $this->hasMany(Registration::class);
    }
    public function Admissions(){
        return $this->hasMany(Admission::class);
    }
}
