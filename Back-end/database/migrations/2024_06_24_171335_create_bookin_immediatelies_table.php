<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookin_immediatelies', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->integer('service_id');
=======
>>>>>>> 7c09a17f7df97da27557df39e9753ad55305433c
            $table->integer('user_id');
            $table->string('promotion_id')->nullable();
            $table->date('date');
            $table->string('location');
<<<<<<< HEAD
=======
            $table->integer('service_id')->nullable();
            $table->string('message')->nullable();
            $table->string('action')->default('request');
>>>>>>> 7c09a17f7df97da27557df39e9753ad55305433c
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookin_immediatelies');
    }
};
