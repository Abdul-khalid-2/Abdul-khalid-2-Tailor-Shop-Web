<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ORD-YYYY-0001
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->foreignId('tailor_id')->nullable()->constrained('tailors')->onDelete('set null');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('restrict');
            $table->foreignId('status_id')->default(1)->constrained('order_statuses')->onDelete('restrict');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->string('order_label', 100)->nullable(); // e.g. "For Self", "For Bilal"
            $table->integer('total_suits')->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('advance_paid', 12, 2)->default(0);
            $table->decimal('balance_due', 12, 2)->default(0);
            $table->decimal('tailor_fee_total', 12, 2)->default(0);
            $table->decimal('tailor_fee_paid', 12, 2)->default(0);
            $table->decimal('tailor_fee_balance', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
