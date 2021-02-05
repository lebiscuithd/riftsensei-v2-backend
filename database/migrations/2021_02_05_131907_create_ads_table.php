<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->integer('coach_id');
            $table->foreign('coach_id')->references('id')->on('users');
            $table->dateTime('coaching_date');
            $table->string('description');
            $table->tinyInteger('ad_rating', 0, 5)->nullable();
            $table->tinyInteger('duration');
            $table->tinyInteger('hourly_rate');
            $table->integer('total_price');
            $table->timestamps();
            $table->enum('status', ['available', 'pending', 'finished', 'rated']);
            $table->tinyInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('users');
            $table->string('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
