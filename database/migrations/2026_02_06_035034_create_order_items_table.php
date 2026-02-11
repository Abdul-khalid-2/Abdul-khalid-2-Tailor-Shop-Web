<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('dress_type_id')->nullable()->constrained('dress_types')->onDelete('restrict');
            $table->string('item_name')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('item_status', ['pending', 'cutting', 'stitching', 'ready', 'delivered'])->default('pending');
            $table->text('instructions')->nullable();
            $table->enum('item_type', ['tailoring', 'product'])->default('tailoring');

            // Fabric source
            $table->boolean('is_inventory_fabric')->default(false);

            // Inventory fabric (future)
            $table->foreignId('fabric_id')->nullable()->constrained('fabrics')->nullOnDelete();

            // Customer fabric info (manual)
            $table->string('fabric_type')->nullable();      // Cotton, Silk
            $table->string('fabric_color')->nullable();     // Navy Blue
            $table->decimal('fabric_meters', 8, 2)->nullable();
            $table->decimal('fabric_rate', 10, 2)->nullable();
            $table->decimal('fabric_cost', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
