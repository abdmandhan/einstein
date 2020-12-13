<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTryOutStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('try_out_student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('try_out_id');
            $table->foreignId('question_id');
            $table->foreignId('answer_id')->nullable();
            $table->longText('answer_essay')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('try_out_student_answers');
    }
}
