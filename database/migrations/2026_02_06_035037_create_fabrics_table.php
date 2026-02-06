<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->string('fabric_type');
            $table->string('color')->nullable();
            $table->decimal('meter', 8, 3)->default(0);
            $table->decimal('rate_per_meter', 8, 2)->nullable();
            $table->decimal('fabric_cost', 10, 2)->default(0);
            $table->enum('status', ['pending', 'ordered', 'received', 'cut', 'delivered'])->default('pending');
            $table->date('expected_date')->nullable();
            $table->date('received_date')->nullable();
            $table->date('cutting_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('supplier')->nullable();
            $table->string('supplier_invoice')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
