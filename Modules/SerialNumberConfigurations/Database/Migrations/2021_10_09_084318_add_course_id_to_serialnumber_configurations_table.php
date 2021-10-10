<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdToSerialnumberConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_number_configurations', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('initialAdmissionNumber');
            $table->string('currentAdmissionNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serialnumber_configurations', function (Blueprint $table) {

        });
    }
}
