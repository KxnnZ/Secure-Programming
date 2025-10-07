<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $t) {
            $t->id();
            $t->foreignId('theater_id')->constrained('theaters')->cascadeOnDelete();
            $t->string('code');                 
            $t->unsignedInteger('row');         
            $t->unsignedInteger('col');         
            $t->enum('type', ['standard','vip','disabled'])->default('standard');
            $t->timestamps();

            $t->unique(['theater_id','code']);
            $t->index(['theater_id','row','col']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
