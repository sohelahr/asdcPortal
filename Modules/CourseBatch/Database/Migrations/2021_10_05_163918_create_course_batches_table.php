<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_batches', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('batch_number');
            $table->string("start_date");
            $table->string("expiry_date");
            $table->enum("status",['1','2'])->comment("1=>active , 2=>inactive");
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
        Schema::dropIfExists('course_batches');
    }
}
