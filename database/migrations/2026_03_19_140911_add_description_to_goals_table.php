<?php

/**
 * Šī migrācija izveido vai maina "2026 03 19 140911 add description to goals table" datubāzes struktūru.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (! Schema::hasColumn('goals', 'description')) {
            Schema::table('goals', function (Blueprint $table) {
                $table->string('description')->default('')->after('target_value');
            });
        }
    }

    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
