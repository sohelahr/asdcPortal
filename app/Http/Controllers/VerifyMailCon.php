<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyMailController extends Controller
{
    //

    function Verify($id){
        $decoded_id = base64_decode($id);
        $user = User::find($decoded_id);
        if($user->is_verified){
            return redirect()->route('login')->with('already_verfied','123');
        }
        else{
            $user->is_verified = 1;
            $user->email_verified_at = now();
            $user->save();
            return redirect()->route('login')->with('email_verfied','123');
        }
    }
}
