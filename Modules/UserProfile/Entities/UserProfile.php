<?php

namespace Modules\UserProfile\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Occupation\Entities\Occupation;
use Modules\Qualification\Entities\Qualification;

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
    function Qualification(){
        return $this->hasOne(Qualification::class,"id","qualification_id");
    }
    
    function Occupation(){
        return $this->hasOne(Occupation::class,"id","occupation_id");
    }
}
