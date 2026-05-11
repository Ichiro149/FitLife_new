<?php

/**
 * Šī migrācija izveido vai maina "2025 10 24 075303 add bio to users table" datubāzes struktūru.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (! Schema::hasTable('users') || Schema::hasColumn('users', 'bio')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'bio')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bio');
        });
    }
};
