<?php

namespace Modules\CourseBatch\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;
use Modules\CourseSlot\Entities\CourseSlot;

class BatchSlotTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','slot_id','batch_id','total_capacity','current_capacity','is_current','status'];
    
    protected static function newFactory()
    {
        return \Modules\CourseBatch\Database\factories\BatchSlotTransactionFactory::new();
    }

    function Course(){
        return $this->belongsTo(Course::class);
    }
    
    public function Slot(){
        return $this->belongsTo(CourseSlot::class,'slot_id');
    }
    
    public function Batch(){
        return $this->belongsTo(CourseBatch::class,'batch_id');
    }

}
