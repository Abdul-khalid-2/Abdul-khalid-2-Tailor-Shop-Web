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
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
