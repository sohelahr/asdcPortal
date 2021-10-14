<?php

namespace Modules\DocumentList\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\CommonMark\Node\Block\Document;
use Modules\Admission\Entities\Admission;

class DocumentList extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\DocumentList\Database\factories\DocumentListFactory::new();
    }
    
    function admissions(){
        return $this->belongsToMany(Admission::class,'admission__documentlists','document_id','admission_id')->withPivot('status');
    }
}
