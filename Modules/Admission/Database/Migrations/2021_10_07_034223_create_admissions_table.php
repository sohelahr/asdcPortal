<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('course_id');
            $table->string('courseslot_id');
            $table->string('admission_remarks');
            $table->string('admission_form_number');
            $table->string('coursebatch_id');
            $table->string('admitted_by');
            $table->string('cancellation_reason');
            $table->string('status');
            $table->string('registration_id');
            $table->string('roll_no');
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
        Schema::dropIfExists('admissions');
    }
}
