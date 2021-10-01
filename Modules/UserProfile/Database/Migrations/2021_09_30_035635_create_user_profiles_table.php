<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string("firstname")->nullable();
            $table->string("lastname")->nullable();
            $table->date("dob")->nullable();
            $table->integer("age")->nullable();
            $table->string("mobile")->nullable();
            $table->integer("occupation_id")->nullable();
            $table->integer("qualification_id")->nullable(); 
            $table->string("qualification_specilization")->nullable();
            $table->enum("qualification_status",['Passed', 'Pursuing', 'Completed', 'Left Incomplete'])->nullable();
            $table->enum("gender",["male","female"])->nullable();
            $table->string("comments")->nullable();
            $table->string("house_details")->nullable();
            $table->string("street")->nullable();
            $table->string("landmark")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("pincode")->nullable();
            $table->string("how_know_us")->nullable();
            $table->string("father_name")->nullable();
            $table->string("father_occupation")->nullable();
            $table->string("fathers_income")->nullable();
            $table->string("fathers_mobile")->nullable();
            $table->string("school_name")->nullable();
            $table->string("employment_status")->nullable();
            $table->string("photo")->nullable();
            $table->enum("is_profile_completed",["0","1"])->comment("1=>Completed 0=>incomplete")->default("0");
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
        Schema::dropIfExists('user_profiles');
    }
}
