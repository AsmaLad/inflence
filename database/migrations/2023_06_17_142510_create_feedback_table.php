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
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('corps'); 
            $table->uuid('user_id'); 
            $table->string('username')->nullable(); 
            $table->uuid('event_uuid'); 

            $table->foreign('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('event_uuid')->references('uuid')->on('events')->onDelete('cascade');
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
        Schema::dropIfExists('feedback');
    }
};
