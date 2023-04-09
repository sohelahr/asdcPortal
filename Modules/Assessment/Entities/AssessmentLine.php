<?php

namespace Modules\Assessment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentLine extends Model
{
    use HasFactory;

    protected $table = 'assessment_lines';
    protected $fillable = ['id','header_id','admission_id','student_id','theory_marks','practical_marks','total_marks','created_by','created_at','updated_at'];
    
    protected static function newFactory()
    {
        return \Modules\Assessment\Database\factories\AssessmentLineFactory::new();
    }
}
