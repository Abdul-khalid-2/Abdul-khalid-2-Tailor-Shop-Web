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
            // Basic Info
            $table->string('name');
            $table->string('fabric_code')->unique();
            $table->string('type'); // silk, cotton
            $table->string('color');
            $table->string('pattern')->nullable();
            $table->integer('gsm')->nullable();
            $table->text('description')->nullable();

            // Stock & Pricing
            $table->decimal('stock_meter', 10, 3);
            $table->decimal('min_stock_meter', 10, 3)->default(0);
            $table->decimal('purchase_rate', 10, 2);
            $table->decimal('selling_rate', 10, 2);

            // Supplier
            $table->string('supplier')->nullable();
            $table->string('supplier_reference')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('invoice_number')->nullable();

            // Properties
            $table->integer('width_inches')->nullable();
            $table->decimal('shrinkage', 5, 2)->nullable();
            $table->string('wash_care')->nullable();
            $table->json('suitable_for')->nullable();

            // Flags
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_imported')->default(false);
            $table->boolean('is_eco_friendly')->default(false);

            // Extra
            $table->string('storage_location')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();

            $table->foreignId('branch_id')->constrained()->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
