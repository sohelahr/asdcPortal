<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_lines', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('admission_id');
            $table->string('feedback_header_id');
            /*1 => Poor 2 => Average 3 => Good 4 => Very Good 5 => Excellent*/
            $table->enum('qOne',[1,2,3,4,5])->comment("How well has your time been utilised here?");
            $table->enum('qTwo',[1,2,3,4,5])->comment("How much this course is helpful for you");
            $table->enum('qThree',[1,2,3,4,5])->comment("How was the quality of the content, grade upon relevance to the course? ");
            $table->enum('qFour',[1,2,3,4,5])->comment("The language used by trainer easy to understand?");
            $table->enum('qFive',[1,2,3,4,5])->comment("How would you rate your trainer’s preparation for the class every time?");
            $table->enum('qSix',[1,2,3,4,5])->comment("Is The trainer was available for consultation outside the class as well? ");
            $table->enum('qSeven',[1,2,3,4,5])->comment("Are you satisfied with the information the trainer covers during the course?");
            $table->enum('qEight',[1,2,3,4,5])->comment("How would you rate the trainer overall teaching effectiveness");
            $table->enum('qNine',[1,2,3,4,5])->comment("How would you rate your trainer’s expertise?");
            $table->enum('qTen',[1,2,3,4,5])->comment("How would you rate your trainer’s empathy?");
            $table->enum('qEleven',[1,2,3,4,5])->comment("How would you rate this course overall?");
            $table->enum('qTwelve',[1,2,3,4,5])->comment("How ASDC staff voluntarily putting efforts for training students who are slow learners.");
            $table->enum('qThirteen',[1,2,3,4,5])->comment("Are you comfortable with the level of quality education at ASDC? ");
            $table->enum('qFourteen',[1,2,3,4,5])->comment("Does the trainer encourage the students to recall what they have learnt in the previous session? ");
            $table->enum('qFifteen',[1,2,3,4,5])->comment("Does the trainer conducts exercise and Activities in the class?");
            $table->enum('qSixteen',[1,2,3,4,5])->comment("Do the trainer provides appropriate examples during explanation?");
            $table->enum('qSeventeen',[1,2,3,4,5])->comment("When I fail to understand the topic the trainer notices me and repeats the topic");
            $table->enum('qEighteen',[1,2,3,4,5])->comment("Does the trainer checks, whether the students have understood the session?");
            $table->enum('qNineteen',[1,2,3,4,5])->comment("Administration Staff Behaviour ");
            $table->enum('qTwentyOne',[1,2,3,4,5])->comment("Do you find Hygiene and Cleanliness maintained at ASDC ?");
            $table->enum('qTwentyTwo',[1,2,3,4,5,6,7,8,9,10])->comment("How do you rate your overall experience of learning at ASDC ?");
            $table->enum('qTwentyThree',[1,2,3,4,5])->comment("Do you recommend ASDC to your friends and relatives?");
            $table->enum('qTwentyFour',[1,2,3,4,5])->comment("Join us as a Volunteer ,Volunteering is giving free service for betterment / upliftment of others");
            $table->longText('feedback');
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
        Schema::dropIfExists('feedback_lines');
    }
}
