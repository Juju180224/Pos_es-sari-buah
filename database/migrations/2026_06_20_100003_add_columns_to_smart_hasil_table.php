<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('smart_hasil', function (Blueprint $table) {
            $table->foreignId('id_alternatif')
                ->nullable()
                ->after('id')
                ->constrained('smart_alternatif')
                ->cascadeOnDelete();

            $table->decimal('nilai_akhir', 8, 2)->default(0)->after('id_alternatif');
            $table->unsignedInteger('ranking')->default(0)->after('nilai_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smart_hasil', function (Blueprint $table) {
            $table->dropForeign(['id_alternatif']);
            $table->dropColumn(['id_alternatif', 'nilai_akhir', 'ranking']);
        });
    }
};
