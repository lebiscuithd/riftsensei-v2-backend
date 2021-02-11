<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lanes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(6);
            $table->unsignedBigInteger('lane_id')->default(6);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lane_id')->references('id')->on('lanes')->onDelete('cascade');
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
        Schema::dropIfExists('user_lanes');
    }
}
