<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('smart_alternatif', 'kode_alternatif')) {
            Schema::table('smart_alternatif', function (Blueprint $table) {
                $table->string('kode_alternatif', 10)->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('smart_alternatif', 'kode_alternatif')) {
            Schema::table('smart_alternatif', function (Blueprint $table) {
                $table->dropColumn('kode_alternatif');
            });
        }
    }
};