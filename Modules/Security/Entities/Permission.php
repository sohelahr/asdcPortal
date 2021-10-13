<?php

namespace Modules\Security\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'permissions';
    
    protected static function newFactory()
    {
        return \Modules\Security\Database\factories\PermissionFactory::new();
    }
}
