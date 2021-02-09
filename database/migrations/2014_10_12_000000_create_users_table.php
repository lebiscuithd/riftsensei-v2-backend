<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_id')->default(1);
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->boolean('verified_coach')->default(false);
            $table->boolean('admin')->default(false);
            $table->integer('wallet')->default(100);
            $table->string('twitter_link')->nullable();
            $table->string('opgg_link')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->default('avatar.png');
            $table->text('description')->nullable();
            $table->text('pedagogy')->nullable();
            $table->integer('coaching_hours')->default(0);
            $table->tinyInteger('coach_rating')->default(0);
            $table->integer('coaching_hours_spent')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
