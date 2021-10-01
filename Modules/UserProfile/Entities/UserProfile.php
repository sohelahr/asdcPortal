<?php

namespace Modules\UserProfile\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\UserProfile\Database\factories\UserProfileFactory::new();
    }

    function User(){
        return $this->belongsTo(User::class,"user_id");
    }
}
