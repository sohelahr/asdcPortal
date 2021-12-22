<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_archive', function (Blueprint $table) {
            $table->id();
            $table->string("Date");
            $table->string("EmployeeCode");
            $table->string("EmployeeName");
            $table->string("Department");
            $table->string("Status");
            $table->string("PunchRecords");
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
        Schema::dropIfExists('attendance_archive');
    }
}
