<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CourseSlot\Entities\CourseSlot;
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
}