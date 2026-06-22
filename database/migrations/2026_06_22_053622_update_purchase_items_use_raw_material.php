<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tambahkan kolom baru dulu (tanpa foreign key)
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->unsignedBigInteger('raw_material_id')->nullable()->after('purchase_id');
        });

        // 2. (OPSIONAL) kalau ada data lama, set default/null-safe
        DB::table('purchase_items')
            ->whereNull('raw_material_id')
            ->update(['raw_material_id' => 1]); 
            // ⚠️ ganti 1 dengan ID raw_material valid di tabel kamu

        // 3. Baru hapus kolom lama
        Schema::table('purchase_items', function (Blueprint $table): void {
            if (Schema::hasColumn('purchase_items', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });

        // 4. Baru tambahkan foreign key
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->foreign('raw_material_id')
                ->references('id')
                ->on('raw_materials')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn('raw_material_id');

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
        });
    }
};