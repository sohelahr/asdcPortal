<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public static function sendRegistrationEmail($reciever,$content,$id){

        $data = [
          'subject' => 'Profile Registration',
          'email' => $reciever,
          'content' =>$content,
          'user_id' =>$id,
        ];

        Mail::send('email.user_registration_mail', $data, function($message) use ($data) {
          $message->to($data['email'])
          ->subject($data['subject']);
        });

        return true;
    }

    public static function sendCourseEnrollmentEmail($reciever,$content){
        $data = [
          'subject' => 'Course Enrollment',
          'email' => $reciever,
          'content' =>$content,
        ];

        Mail::send('email.course_registrations_template', $data, function($message) use ($data) {
          $message->to($data['email'])
          ->subject($data['subject']);
        });

        return true;
    }

    public static function sendAdminCreatedUserEmail($reciever,$content){
        $data = [
          'subject' => 'Account Creation on Asdc',
          'email' => $reciever,
          'content' =>$content,
        ];

        Mail::send('email.admin_user_registrations_mail', $data, function($message) use ($data) {
          $message->to($data['email'])
          ->subject($data['subject']);
        });

        return true;
    }


}
