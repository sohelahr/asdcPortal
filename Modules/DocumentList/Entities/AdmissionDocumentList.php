<?php

namespace Modules\DocumentList\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission_DocumentList extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\DocumentList\Database\factories\AdmissionDocumentListFactory::new();
    }
}
