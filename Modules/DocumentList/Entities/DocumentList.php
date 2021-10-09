<?php

namespace Modules\DocumentList\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\CommonMark\Node\Block\Document;

class DocumentList extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\DocumentList\Database\factories\DocumentListFactory::new();
    }

    function admisions(){
        return $this->belongsToMany(Document::class,'admission__documentlists','admission_id','document_id')->withPivot('status');
    }
}
