<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionDocumentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission__documentlists', function (Blueprint $table) {
            $table->id();
            $table->string('admission_id');
            $table->string('document_id');
            $table->enum('status',['1','2'])->comment("1=>with institute , 2=> returned")->default('1');
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
        Schema::dropIfExists('admission__document_lists');
    }
}
