<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\UserProfile\Entities\UserProfile;

class RemoveSuspension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:suspension-remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes suspended tag from student if one year of suspension has passed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get suspended users list
        $students = UserProfile::where('status','2')->get();
        $date_now = time();
        foreach($students as $student){
            if($date_now >= strtotime($student->suspended_till)){
                $student->status ='0';
                $student->save();
            }
        }
        $this->info('Suspension dates checked');
    }
}
