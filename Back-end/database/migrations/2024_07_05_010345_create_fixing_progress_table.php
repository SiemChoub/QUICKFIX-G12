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
        Schema::create('fixing_progress', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->integer('booking_id');
            $table->integer('fixer_id');
=======
            $table->unsignedBigInteger('booking_type_id');
            $table->string('type');
            $table->unsignedBigInteger('fixer_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('booking_id');
>>>>>>> 27b21cd29d6977db96b4d6e542c474b31c8f0467
            $table->string('action')->default('progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixing_progress');
    }
};
