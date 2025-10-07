<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('showtime_id')->constrained('showtimes')->cascadeOnDelete();
            $t->unsignedInteger('total_price')->default(0);
            $t->enum('status', ['pending','paid','cancelled'])->default('pending');
            $t->dateTime('booked_at')->nullable();
            $t->timestamps();

            $t->index(['showtime_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
