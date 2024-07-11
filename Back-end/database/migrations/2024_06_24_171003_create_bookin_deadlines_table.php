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
        Schema::create('bookin_deadlines', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id')->nullable();
            $table->string('date_todo');
            $table->longText('image')->nullable();
            $table->string('message')->nullable();
            $table->string('action')->default('request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookin_deadlines');
    }
};
