<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssesmentHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assesment_headers', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_name');
            $table->integer('course_id');
            $table->integer('course_slot_id');
            $table->integer('course_batch_id');
            $table->integer('instructor_id');
            $table->string('held_on');
            $table->integer('max_theory');
            $table->integer('max_practical')->nullable();
            $table->integer('total_marks');
            $table->integer('created_by');
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
        Schema::dropIfExists('assesment_headers');
    }
}
