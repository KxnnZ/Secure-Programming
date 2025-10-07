<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('showtimes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $t->foreignId('theater_id')->constrained('theaters')->cascadeOnDelete();
            $t->dateTime('start_at');
            $t->unsignedInteger('price');
            $t->timestamps();

            $t->index(['movie_id','theater_id','start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
