<?php

namespace Modules\Admission\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\DocumentList\Entities\DocumentList;
use Modules\Registration\Entities\Registration;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Admission\Database\factories\AdmissionFactory::new();
    }
    
    function Registration(){
        return $this->belongsTo(Registration::class);
    }

    function AdmittedBy(){
        return $this->belongsTo(User::class,'admitted_by');
    }

    function Course(){
        return $this->hasOne(Course::class,'id','course_id');
    }
    function CourseSlot(){
        return $this->hasOne(CourseSlot::class,'id','courseslot_id');
    }
    
    function CourseBatch(){
        return $this->hasOne(CourseBatch::class,'id','coursebatch_id');
    }
    function documents(){
        return $this->belongsToMany(DocumentList::class,'admission__documentlists','admission_id','document_id')->withPivot('status','student_id');
    }
    
    function Student(){
        return $this->belongsTo(User::class,'student_id','id');
    }
}
