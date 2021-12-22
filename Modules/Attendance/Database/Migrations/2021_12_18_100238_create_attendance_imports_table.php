<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /* Date	 Employee Code 	Employee Name	
        Company 	Department	Category 	Degination	
        Shift	Early By 	Status 	Punch Records 	Overtime */
    public function up()
    {
        Schema::create('attendance_imports', function (Blueprint $table) {
            $table->id();
            $table->string("Date");
            $table->string("EmployeeCode");
            $table->string("EmployeeName");
            $table->string("Company");
            $table->string("Department");
            $table->string("Category");
            $table->string("Designation");
            $table->string("Shift");
            $table->string("EarlyBy");
            $table->string("Status");
            $table->string("PunchRecords");
            $table->string("Overtime");
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
        Schema::dropIfExists('attendance_imports');
    }
}
