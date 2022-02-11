<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Modules\UserProfile\Entities\UserProfile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $name = $request->first_name ." ".$request->last_name;
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => '3',
        ]);
        if(isset($user))
        {
            //event(new Registered($user));
            $userprofile = new UserProfile();
            $userprofile->firstname = $request->first_name;
            $userprofile->lastname = $request->last_name;
            $userprofile->user_id = $user->id;
            $userprofile->save();
            MailController::sendRegistrationEmail($request->email,$user->name,$user->id);
            return redirect('/register/success/'.base64_encode($user->id));
            //Auth::login($user);
            //return redirect(RouteServiceProvider::HOME);
        }
        else
        {
            return redirect()->back()->with('error','Opps, Something went wrong');
        }
    }

    public function confirm($id)
    {
        $user = User::find(base64_decode($id));
        return view('auth.register-confirm',compact('user'));
    }

    public function resendVerificationEmail($id)
    {
        $user = User::find(base64_decode($id));
        if(isset($user))
        {
            MailController::sendRegistrationEmail($user->email,$user->name,$user->id);
            return redirect()->back()->with('success','Email resent successfully.');
        }
        else
        {
            return redirect()->back()->with('error','Opps, Something went wrong we are unable to send the email.');
        }
    }
}
