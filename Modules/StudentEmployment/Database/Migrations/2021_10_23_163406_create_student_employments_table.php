<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_employments', function (Blueprint $table) {
            $table->id();
            $table->string('admission_id');
            $table->string('company_name');
            $table->string('designation');
            $table->string('industry');
            $table->string('salary');
            $table->string('location');
            $table->enum('employment_type',['0','1','2'])->comment('1-> permanent , 2->contract , 3->Internship');
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
        Schema::dropIfExists('student_employments');
    }
}
