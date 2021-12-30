<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\CourseBatch\Entities\CourseBatch;

class MarkCurrentBatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursebatch:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check start and end dates of batches and mark current batch';

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
                        $transaction->save();
                    }
                }
            }

            $this->info('Course batch '.$coursebatch->batch_number. ' marked '.$coursebatch->is_current);
        }  

    }
}
