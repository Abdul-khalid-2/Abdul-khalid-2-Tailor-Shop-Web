<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->index('code');
            $table->index('is_active');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index(['branch_id', 'created_at']);
            $table->fullText(['name', 'reference', 'notes']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['branch_id', 'status_id', 'order_date']);
            $table->index(['customer_id', 'status_id']);
            $table->index(['payment_status_id', 'delivery_date']);
            $table->index(['order_date', 'delivery_date']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['order_id', 'dress_type_id']);
            $table->index(['item_status', 'created_at']);
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->index(['order_item_id', 'is_current']);
        });

        Schema::table('tailor_assignments', function (Blueprint $table) {
            $table->index(['tailor_id', 'status_id']);
            $table->index(['order_item_id', 'status_id']);
            $table->index(['assign_date', 'expected_date']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index(['order_id', 'payment_date']);
            $table->index(['payment_method_id', 'payment_date']);
            $table->index('receipt_number');
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->index(['is_active', 'start_date', 'end_date']);
            $table->index('code');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index(['expense_date', 'category']);
            $table->index(['branch_id', 'expense_date']);
        });

        Schema::table('order_status_logs', function (Blueprint $table) {
            $table->index(['order_id', 'changed_at']);
        });

        Schema::table('measurement_templates', function (Blueprint $table) {
            $table->index(['customer_id', 'dress_type_id']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->index('branch_id');
        });
    }

    public function down(): void
    {
        // Remove indexes
        Schema::table('branches', function (Blueprint $table) {
            $table->dropIndex(['branches_code_index']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['branch_id', 'created_at']);
            $table->dropFullText(['name', 'reference', 'notes']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['branch_id', 'status_id', 'order_date']);
            $table->dropIndex(['customer_id', 'status_id']);
            $table->dropIndex(['payment_status_id', 'delivery_date']);
            $table->dropIndex(['order_date', 'delivery_date']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'dress_type_id']);
            $table->dropIndex(['item_status', 'created_at']);
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->dropIndex(['order_item_id', 'is_current']);
        });

        Schema::table('fabrics', function (Blueprint $table) {
            $table->dropIndex(['order_item_id', 'status']);
            $table->dropIndex(['fabric_type', 'color']);
        });

        Schema::table('tailor_assignments', function (Blueprint $table) {
            $table->dropIndex(['tailor_id', 'status_id']);
            $table->dropIndex(['order_item_id', 'status_id']);
            $table->dropIndex(['assign_date', 'expected_date']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'payment_date']);
            $table->dropIndex(['payment_method_id', 'payment_date']);
            $table->dropIndex(['receipt_number']);
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'start_date', 'end_date']);
            $table->dropIndex(['branches_code_index']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['expense_date', 'category']);
            $table->dropIndex(['branch_id', 'expense_date']);
        });

        Schema::table('order_status_logs', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'changed_at']);
        });

        Schema::table('measurement_templates', function (Blueprint $table) {
            $table->dropIndex(['customer_id', 'dress_type_id']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex(['branch_id']);
        });
    }
};
