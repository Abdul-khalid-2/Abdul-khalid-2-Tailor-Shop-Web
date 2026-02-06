<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Order Statuses
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('color')->default('#6b7280');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->timestamps();
        });

        // Payment Statuses
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('color')->default('#6b7280');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        // Payment Methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Assignment Statuses
        Schema::create('assignment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('color')->default('#6b7280');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        // Seed data - FIXED: Specify all column names
        DB::table('order_statuses')->insert([
            [
                'name' => 'Pending',
                'slug' => 'pending',
                'sort_order' => 1,
                'color' => '#f59e0b',
                'is_active' => true,
                'is_completed' => false,
                'is_cancelled' => false
            ],
            [
                'name' => 'Confirmed',
                'slug' => 'confirmed',
                'sort_order' => 2,
                'color' => '#3b82f6',
                'is_active' => true,
                'is_completed' => false,
                'is_cancelled' => false
            ],
            [
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'sort_order' => 3,
                'color' => '#8b5cf6',
                'is_active' => true,
                'is_completed' => false,
                'is_cancelled' => false
            ],
            [
                'name' => 'Ready',
                'slug' => 'ready',
                'sort_order' => 4,
                'color' => '#10b981',
                'is_active' => true,
                'is_completed' => false,
                'is_cancelled' => false
            ],
            [
                'name' => 'Delivered',
                'slug' => 'delivered',
                'sort_order' => 5,
                'color' => '#059669',
                'is_active' => true,
                'is_completed' => true,
                'is_cancelled' => false
            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'sort_order' => 6,
                'color' => '#ef4444',
                'is_active' => true,
                'is_completed' => false,
                'is_cancelled' => true
            ],
        ]);

        DB::table('payment_statuses')->insert([
            [
                'name' => 'Pending',
                'slug' => 'pending',
                'sort_order' => 1,
                'color' => '#f59e0b',
                'is_active' => true,
                'is_paid' => false
            ],
            [
                'name' => 'Partial',
                'slug' => 'partial',
                'sort_order' => 2,
                'color' => '#8b5cf6',
                'is_active' => true,
                'is_paid' => false
            ],
            [
                'name' => 'Paid',
                'slug' => 'paid',
                'sort_order' => 3,
                'color' => '#10b981',
                'is_active' => true,
                'is_paid' => true
            ],
            [
                'name' => 'Overdue',
                'slug' => 'overdue',
                'sort_order' => 4,
                'color' => '#ef4444',
                'is_active' => true,
                'is_paid' => false
            ],
        ]);

        DB::table('payment_methods')->insert([
            [
                'name' => 'Cash',
                'slug' => 'cash',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Credit Card',
                'slug' => 'credit-card',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Bank Transfer',
                'slug' => 'bank-transfer',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Mobile Payment',
                'slug' => 'mobile-payment',
                'sort_order' => 4,
                'is_active' => true
            ],
        ]);

        DB::table('assignment_statuses')->insert([
            [
                'name' => 'Assigned',
                'slug' => 'assigned',
                'sort_order' => 1,
                'color' => '#3b82f6',
                'is_active' => true,
                'is_completed' => false
            ],
            [
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'sort_order' => 2,
                'color' => '#8b5cf6',
                'is_active' => true,
                'is_completed' => false
            ],
            [
                'name' => 'Completed',
                'slug' => 'completed',
                'sort_order' => 3,
                'color' => '#10b981',
                'is_active' => true,
                'is_completed' => true
            ],
            [
                'name' => 'Delayed',
                'slug' => 'delayed',
                'sort_order' => 4,
                'color' => '#ef4444',
                'is_active' => true,
                'is_completed' => false
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_statuses');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_statuses');
        Schema::dropIfExists('order_statuses');
    }
};
