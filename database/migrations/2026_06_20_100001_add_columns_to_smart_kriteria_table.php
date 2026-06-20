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
        Schema::table('smart_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria')->nullable()->after('id');
            $table->string('nama_kriteria')->nullable()->after('kode_kriteria');
            $table->decimal('bobot', 8, 2)->default(0)->after('nama_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smart_kriteria', function (Blueprint $table) {
            $table->dropColumn(['kode_kriteria', 'nama_kriteria', 'bobot']);
        });
    }
};
