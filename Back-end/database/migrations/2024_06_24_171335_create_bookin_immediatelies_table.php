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
            $table->integer('user_id');
            $table->string('promotion_id')->nullable();
            $table->date('date');
            $table->string('location');
=======
            $table->integer('service_id')->nullable();
            $table->longText('image')->nullable();
            $table->string('message')->nullable();
            $table->string('action')->default('request');
>>>>>>> admin-page
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
