<?php

use App\Models\RawMaterial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table): void {
            // Drop foreign key & kolom lama
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');

            // Tambah kolom baru
            $table->foreignIdFor(RawMaterial::class)
                ->nullable()
                ->after('purchase_id')
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->index(['raw_material_id', 'purchase_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn('raw_material_id');

            $table->foreignIdFor(\App\Models\Product::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
