<?php

/**
 * Šī migrācija izveido vai maina "2026 04 22 000001 add full name gender to users table" datubāzes struktūru.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!\Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name', 255)->nullable();
            }
            if (!\Schema::hasColumn('users', 'age')) {
                $table->integer('age')->nullable();
            }
            if (!\Schema::hasColumn('users', 'weight')) {
                $table->decimal('weight', 5, 2)->nullable();
            }
            if (!\Schema::hasColumn('users', 'height')) {
                $table->decimal('height', 5, 2)->nullable();
            }
            if (!\Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter(['full_name', 'age', 'weight', 'height', 'gender'], fn($col) => \Schema::hasColumn('users', $col)));
        });
    }
};
