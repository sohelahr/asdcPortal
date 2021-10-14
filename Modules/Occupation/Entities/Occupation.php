<?php

namespace Modules\Occupation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserProfile\Entities\UserProfile;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Occupation\Database\factories\OccupationFactory::new();
    }
    
    public function UserProfile(){
        return $this->hasMany(UserProfile::class);
    }
}
