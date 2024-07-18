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
=======
            // $table->integer('service_id');
>>>>>>> b19eb38ff361c44e7f5883fd6b8534771c1c8c0f
            $table->integer('user_id');
            $table->integer('service_id')->nullable();
            $table->string('promotion_id')->nullable();
            $table->date('date');
            $table->string('latitude');
            $table->string('longitude');    
            $table->string('message')->nullable();
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
