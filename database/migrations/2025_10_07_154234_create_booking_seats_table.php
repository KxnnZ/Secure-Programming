<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $t->foreignId('seat_id')->constrained('seats')->cascadeOnDelete();
            $t->foreignId('showtime_id')->constrained('showtimes')->cascadeOnDelete();
            $t->timestamps();

            $t->unique(['showtime_id','seat_id']);
            $t->index(['booking_id','seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
