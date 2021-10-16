<?php
/**
 * Created by PhpStorm.
 * User: Sohell
 * Date: 5/6/2020
 * Time: 5:50 AM
 */

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Security\Entities\Permission;
use Modules\Security\Entities\UserPermission;

class CheckPermission
{
    public static function hasPermission($slug)
    {
        if(Auth::user()->user_type == '1')
        {
            return true;
        }
        else
        {
            $permission_id = Permission::where('slug',$slug)->first('id');
            $user_id = Auth::user()->id;
            if(isset($permission_id) && isset($user_id))
            {
                $check_permission = UserPermission::where('user_id',$user_id)->where('permission_id',$permission_id->id)->first();
                if($check_permission)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }
}