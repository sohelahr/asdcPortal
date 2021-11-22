<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchSlotTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_slot_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('slot_id');
            $table->integer('batch_id');
            $table->integer('total_capacity');
            $table->integer('current_capacity');
            $table->integer('is_current');
            $table->enum('status',['0','1'])->comment('0=>inactive,1=>active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_slot_transactions');
    }
}
