<?php

namespace Modules\Instructor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [];
    

    public function Course(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
