<?php

namespace Modules\Security\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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

    function setSecurityPermission(Request $request)
    {
        $user_id = $request->user_id;
        UserPermission::where('user_id',$user_id)->delete();
        if(isset($request->permissions) && count($request->permissions) > 0)
        {
            foreach($request->permissions as $key => $permission)
            {
                $user_permission_arr['user_id'] = $user_id;
                $user_permission_arr['permission_id'] = $permission;
                $user_permission_arr['created_by'] = Auth::user()->id;
                UserPermission::create($user_permission_arr);
            }
            /* // Make user active
            $user_status = User::find($user_id);
            if(isset($user_status))
            {
                $user_status->status = "1";
                $user_status->save();
            } */

        }
        return redirect('/subadmin')->with('success', 'Security permission added successfully...!');
    }
}
