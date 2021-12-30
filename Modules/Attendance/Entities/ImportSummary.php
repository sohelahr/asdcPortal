<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportSummary extends Model
{
    protected $table = "import_summaries";

    protected $fillable = [
    	'id',
    	'original_file',
    	'total_record',
    	'failed_record',
        'failed_transaction_file',
    	'success_record',
        'success_transaction_file',
    	'status',
    	'created_at',
    	'updated_at'
    ];
}
