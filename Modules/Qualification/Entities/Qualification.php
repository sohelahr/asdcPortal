<?php

namespace Modules\Qualification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registration\Entities\Registration;
use Modules\UserProfile\Entities\UserProfile;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Qualification\Database\factories\QualificationFactory::new();
    }
    
    public function UserProfile(){
        return $this->hasMany(UserProfile::class);
    }
}
