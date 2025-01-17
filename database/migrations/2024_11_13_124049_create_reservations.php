<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // Creates an unsigned BIGINT primary key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('table_id'); // No constraint for now
            $table->string('special_request')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('paid')->default(false);
            $table->boolean('email_send')->default(false);
            $table->boolean('present')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
