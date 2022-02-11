<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\UserProfile\Entities\UserProfile;

class CronJobController extends Controller
{
    //

    public function MarkCurrentBatches(){
        try{
            $coursebatches = CourseBatch::all();
            foreach ($coursebatches as $coursebatch) {
                $date_now = time();
                if(strtotime($coursebatch->start_date) <= $date_now && $date_now < strtotime($coursebatch->expiry_date) ){
                    $coursebatch->is_current = '1';
                }
                else{
                    $coursebatch->is_current = '0';
                }
                if($coursebatch->save()){
                    $transactions = BatchSlotTransaction::where('batch_id',$coursebatch->id)->get();
                    if(count($transactions) > 0)
                    {
                        foreach($transactions as $transaction){
                            $transaction->is_current = $coursebatch->is_current ? '1':'0';
                            $result = $transaction->save();
                            if(!$result){
                                DB::table('cron_job_logger')->insert([
                                    'cron_type' =>  "Marking Current Batches",
                                    'error' => "Couldn't save transaction",
                                    'record_identifier' => $transaction->id,
            
                                ]);
                            }
                        }
                    }
                }
                else{
                    DB::table('cron_job_logger')->insert([
                        'cron_type' =>  "Marking Current Batches",
                        'error' => "Couldn't save coursebatch",
                        'record_identifier' => $coursebatch->id,

                    ]);
                }

            }

        }
        catch(\Illuminate\Database\QueryException $exception){   
            DB::table('cron_job_logger')->insert([
                'cron_type' =>  "Marking Current Batches",
                'error' => json_encode($exception->errorInfo),
                'record_identifier' => 'None'
            ]);
        }
         
    }



    public function MarkAdmissionComplete(){
        $coursebatches = CourseBatch::all();
        foreach ($coursebatches as $coursebatch) {
            $date_now = time();
            if($date_now >= strtotime($coursebatch->expiry_date) ){
                try{
                    DB::table('admissions')->where('status','=','1')->where('coursebatch_id',$coursebatch->id)->update(['status'=>'2']);
                }
                catch(\Illuminate\Database\QueryException $exception){   
                    DB::table('cron_job_logger')->insert([
                        'cron_type' =>  "Marking Admissions Complete",
                        'error' => json_encode($exception->errorInfo),
                        'record_identifier' => $coursebatch->id,
                    ]);
                }
            }
        }
    }

    public function RemoveSuspension(){
        $students = UserProfile::where('status','2')->get();
        $date_now = time();
        foreach($students as $student){
            try{
                if($date_now >= strtotime($student->suspended_till)){
                    $student->status ='0';
                    $student->save();
                }
            }
            catch(\Illuminate\Database\QueryException $exception){   
                DB::table('cron_job_logger')->insert([
                    'cron_type' =>  "Removing Suspension",
                    'error' => json_encode($exception->errorInfo),
                    'record_identifier' => $student->id,
                ]);
            }
        }
    }

    public function MarkFeedbacks(){

        $feedback_headers = DB::table('feedback_headers')->get();

        foreach ($feedback_headers as $header) {
            try{
                //default active
                $status = 1;
                //if start date greater than today status initialized
                if(strtotime($header->start_date) > time()){
                    $status = '0';
                }
                //if expired date less than today mark expired
                if(strtotime($header->end_date) < time())
                {
                    $status = '2';
                }
                
                
                $insert = DB::table('feedback_headers')
                            ->where('id',$header->id)
                            ->update([
                                'status' => $status,
                            ]);
            }
            catch(\Illuminate\Database\QueryException $exception){   
                DB::table('cron_job_logger')->insert([
                    'cron_type' =>  "Marking Feedbacks",
                    'error' => json_encode($exception->errorInfo),
                    'record_identifier' => $header->id,
                ]);
            }
            
        }
    }
}
