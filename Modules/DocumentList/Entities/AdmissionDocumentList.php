<?php

namespace Modules\DocumentList\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdmissionDocumentList extends Model
{
    use HasFactory;

    protected $fillable = [];
    public $table = 'admission__documentlists';
    protected static function newFactory()
    {
        return \Modules\DocumentList\Database\factories\AdmissionDocumentListFactory::new();
    }
}
