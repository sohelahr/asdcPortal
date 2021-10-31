<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\CourseBatch\Entities\CourseBatch;

class MarkAdmissionComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursebatch:training-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks all the admission in this batch as complete if the batch has ended';

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
        $coursebatches = CourseBatch::all();
        foreach ($coursebatches as $coursebatch) {
            $date_now = time();
            if($date_now >= strtotime($coursebatch->expiry_date) ){
                DB::table('admissions')->where('status','=','1')->update(['status'=>'2']);
            }
        }
        $this->info('Admission were updated');
    }
}
