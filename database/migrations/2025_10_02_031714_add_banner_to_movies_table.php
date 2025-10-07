<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'poster_path')) {
                $table->string('poster_path')->nullable();   
            }
            if (!Schema::hasColumn('movies', 'banner_path')) {
                $table->string('banner_path')->nullable();   
            }
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            if (Schema::hasColumn('movies', 'banner_path')) $table->dropColumn('banner_path');
            if (Schema::hasColumn('movies', 'poster_path')) $table->dropColumn('poster_path');
        });
    }
};
