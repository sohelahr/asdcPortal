<?php

namespace Modules\Security\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','permission_id','created_by'];
    protected $table = 'user_permissions';
    
    protected static function newFactory()
    {
        return \Modules\Security\Database\factories\UserPermissionFactory::new();
    }
}
