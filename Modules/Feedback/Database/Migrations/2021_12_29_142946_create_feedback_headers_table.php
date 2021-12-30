<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_headers', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('instructor_id');
            $table->string('start_date');
            $table->string('end_date');
            $table->enum('status',[0,1,2])->comment("0 => initialized 1 => active 2 => expired");
            $table->string('initialized_by');
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
        Schema::dropIfExists('feedback_headers');
    }
}
