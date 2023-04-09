<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssesmentLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('header_id');
            $table->integer('admission_id');
            $table->integer('student_id');
            $table->integer('theory_marks')->default(0);
            $table->integer('practical_marks')->default(0);
            $table->integer('total_marks')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('assesment_lines');
    }
}
