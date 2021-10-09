<?php

namespace Modules\CourseBatch\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;

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
}
