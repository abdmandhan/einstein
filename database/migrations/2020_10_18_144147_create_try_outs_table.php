<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTryOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('try_outs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('difficulty_id');
            $table->dateTime('date_start');
            $table->dateTime('date_finish');
            $table->time('time');
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
        Schema::dropIfExists('try_outs');
    }
}
