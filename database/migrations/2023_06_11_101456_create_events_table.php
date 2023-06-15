<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('progress')->default('0');
            $table->enum('status', ['en cours','terminer'])->default('en cours');

            $table->uuid('contributeur_id');
            $table->uuid('user_id');

            $table->foreign('contributeur_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('uuid')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
};
