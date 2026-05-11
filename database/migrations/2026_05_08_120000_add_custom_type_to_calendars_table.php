<?php

/**
 * Šī migrācija izveido vai maina "2026 05 08 120000 add custom type to calendars table" datubāzes struktūru.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->string('type', 50)->change();
            $table->string('custom_type', 30)->nullable()->after('type');
        });
    }

    public function down(): void
    {
        DB::table('calendars')
            ->where('type', 'custom')
            ->update([
                'type' => 'workout',
                'custom_type' => null,
            ]);

        Schema::table('calendars', function (Blueprint $table) {
            $table->dropColumn('custom_type');
            $table->enum('type', [
                'workout',
                'rest',
                'goal',
                'running',
                'gym',
                'yoga',
                'cardio',
                'stretching',
                'cycling',
                'swimming',
                'weightlifting',
                'pilates',
                'hiking',
                'boxing',
                'dance',
                'crossfit',
                'walking',
                'meditation',
                'tennis',
                'basketball',
                'soccer',
                'climbing',
                'rowing',
                'martial_arts',
                'recovery',
            ])->change();
        });
    }
};