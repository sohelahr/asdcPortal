<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string("attendance_date");
            $table->string("roll_number");
            $table->integer("course_id");
            $table->integer("student_id");
            $table->integer("admission_id");
            $table->enum("status",[0,1,2,3,4])->comment("0 -> absent, 1 -> noPunchOut,2 -> present, 3 -> weeklyoff,4 -> holiday");
            $table->string("punch_record");
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
        Schema::dropIfExists('attendances');
    }
}
