<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try{
          Mail::send('email.user_registration_mail', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
          });
        }
        catch(\Exception  $exception){
            DB::table('error_logger')->insert([
                    'email' =>  $data['email'],
                    'name' => $content,
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => $exception->getMessage(),
            ]);  
        }
         if (Mail::failures()) {
          // return failed mails
          foreach(Mail::failures() as $email_address) {
            DB::table('error_logger')->insert([
                    'email' =>  $email_address,
                    'name' => "Not Found",
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => "Sending Registration Mail Failed for this user",
            ]);  
          }
        }
        else{
            $user = User::where("email",$data['email'])->first();
            if($user){
              $user->email_recieved = 1;
              $user->save();
            }
        }
        return true;
    }

    public static function sendCourseEnrollmentEmail($reciever,$content){
        $data = [
          'subject' => 'Course Enrollment',
          'email' => $reciever,
          'content' =>$content,
        ];
        try{
            Mail::send('email.course_registrations_template', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
          });
        }
        catch(\Exception  $exception){
            DB::table('error_logger')->insert([
                    'email' =>  $data['email'],
                    'name' => $content,
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => $exception->getMessage(),
            ]);  
        }

        if (Mail::failures()) {
          // return failed mails
          foreach(Mail::failures() as $email_address) {
            DB::table('error_logger')->insert([
                    'email' =>  $email_address,
                    'name' => "Not Found",
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => "Sending Course Enrollment Mail Failed for this user",
            ]);  
          }
        }
        return true;
    }

    public static function sendAdminCreatedUserEmail($reciever,$content){
        $data = [
          'subject' => 'Account Creation on Asdc',
          'email' => $reciever,
          'content' =>$content,
        ];
        try{
          Mail::send('email.admin_user_registrations_mail', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
          });
          
        }
        catch(\Exception  $exception){
            DB::table('error_logger')->insert([
                    'email' =>  $data['email'],
                    'name' => $content,
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => $exception->getMessage(),
            ]);  
        }
        if (Mail::failures()) {
          // return failed mails
          foreach(Mail::failures() as $email_address) {
            DB::table('error_logger')->insert([
                    'email' =>  $email_address,
                    'name' => "Not Found",
                    'fail_step' => 'Laravel Mail Sender',
                    'error_message' => "Sending Admin Registration Mail Failed for this user",
            ]);  
          }
        }
        return true;
    }


}
