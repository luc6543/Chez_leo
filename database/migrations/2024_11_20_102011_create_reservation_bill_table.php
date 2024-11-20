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
        Schema::create('reservation_bill', function (Blueprint $table) {
            $table->foreignId('reservation_id')
                ->constrained('reservations') // References 'id' on 'reservations'
                ->onDelete('cascade');
            $table->foreignId('bill_id')
                ->constrained('bills') // References 'id' on 'bills'
                ->onDelete('cascade');
            $table->timestamps(); // Optional: only include if needed
            $table->primary(['reservation_id', 'bill_id']); // Composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_bill');
    }
};
