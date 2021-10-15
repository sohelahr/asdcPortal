<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public static function sendRegistrationEmail($reciever,$content){
        $data = [
          'subject' => 'Profile Registration',
          'email' => $reciever,
          'content' =>$content,
        ];

        Mail::send('email.user_registration_mail', $data, function($message) use ($data) {
          $message->to($data['email'])
          ->subject($data['subject']);
        });

        return true;
    }
}
