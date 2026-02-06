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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();

            // fabric | readymade | accessory
            $table->enum('type', ['fabric', 'readymade', 'accessory']);

            $table->decimal('sale_price', 10, 2);
            $table->decimal('cost_price', 10, 2)->default(0);

            // fabric => meter, readymade => piece
            $table->string('unit')->default('piece');

            $table->decimal('stock_quantity', 10, 3)->default(0);

            $table->string('color')->nullable();
            $table->string('brand')->nullable();

            $table->foreignId('branch_id')->nullable()
                ->constrained('branches')->onDelete('set null');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
