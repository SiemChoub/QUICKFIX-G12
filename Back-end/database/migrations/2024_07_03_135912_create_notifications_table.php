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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            // $table->integer('user_id');
            // $table->boolean('read_at')->nullable();
            // $table->unsignedInteger('sender_id')->nullable(); // user_id of the person who sent the notification
            $table->boolean('role_id')->nullable();
            $table->unsignedInteger('booking_id')->nullable(); // booking_id of the booking related to the notification if any
            // $table->unsignedInteger('service_id')->nullable(); // service_id of the service related to the notification if any
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
