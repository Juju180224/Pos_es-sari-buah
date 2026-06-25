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
        Schema::table('user_purchase_cart', function (Blueprint $table): void {
            // Drop the old unique constraint first (it references product_id)
            $table->dropUnique(['user_id', 'product_id']);

            // Drop foreign key & old column
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');

            // Add new column
            $table->foreignIdFor(RawMaterial::class)
                ->nullable()
                ->after('user_id')
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::table('user_purchase_cart', function (Blueprint $table): void {
            $table->unique(['user_id', 'raw_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_purchase_cart', function (Blueprint $table): void {
            $table->dropUnique(['user_id', 'raw_material_id']);
            $table->dropForeign(['raw_material_id']);
            $table->dropColumn('raw_material_id');

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::table('user_purchase_cart', function (Blueprint $table): void {
            $table->unique(['user_id', 'product_id']);
        });
    }
};
