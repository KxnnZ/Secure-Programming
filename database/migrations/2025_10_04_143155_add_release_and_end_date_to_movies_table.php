<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'release_date')) {
                $table->date('release_date')->nullable(); // nullable supaya data lama aman
            }
            if (!Schema::hasColumn('movies', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            if (Schema::hasColumn('movies', 'end_date')) $table->dropColumn('end_date');
            if (Schema::hasColumn('movies', 'release_date')) $table->dropColumn('release_date');
        });
    }
};
    