<?php

namespace Modules\Security\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Security\Entities\Permission;
use Modules\Security\Entities\UserPermission;

class SecurityController extends Controller
{
    function setPermission($id)
    {
        $user_details = User::find($id);
        $permissions = Permission::where('status','1')->orderBy('module')->get(['id','name','module'])->toArray();
        $user_permission = UserPermission::where('user_id',$id)->get()->pluck('permission_id')->toArray();
        $permission_arr = $this->arrayGroupBy($permissions,'module');
        return view('security::permissions',compact('permission_arr','user_details','user_permission'));
    }
    public function arrayGroupBy($array, $key) {
        $return = array();
        foreach ($array as $val)
        {
            $val = (array) $val;
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}
