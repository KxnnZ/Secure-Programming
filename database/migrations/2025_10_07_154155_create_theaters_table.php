<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('theaters', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedInteger('rows'); 
            $t->unsignedInteger('cols');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theaters');
    }
};
