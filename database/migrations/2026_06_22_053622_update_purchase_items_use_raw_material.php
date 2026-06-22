<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->foreignId('raw_material_id')
                ->nullable()
                ->after('purchase_id')
                ->constrained('raw_materials')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table): void {
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn('raw_material_id');
            $table->foreignId('product_id')
                ->nullable()
                ->after('purchase_id')
                ->constrained('products')
                ->cascadeOnDelete();
        });
    }
};