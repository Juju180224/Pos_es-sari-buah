<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('smart_penilaian', function (Blueprint $table) {
            $table->foreignId('id_alternatif')
                  ->after('id')
                  ->constrained('smart_alternatif')
                  ->onDelete('cascade');
            $table->decimal('c1', 8, 2)->default(0)->after('id_alternatif');
            $table->decimal('c2', 8, 2)->default(0)->after('c1');
            $table->decimal('c3', 8, 2)->default(0)->after('c2');
            $table->decimal('c4', 8, 2)->default(0)->after('c3');
            $table->decimal('c5', 8, 2)->default(0)->after('c4');
        });
    }

    public function down(): void
    {
        Schema::table('smart_penilaian', function (Blueprint $table) {
            $table->dropForeign(['id_alternatif']);
            $table->dropColumn(['id_alternatif', 'c1', 'c2', 'c3', 'c4', 'c5']);
        });
    }
};