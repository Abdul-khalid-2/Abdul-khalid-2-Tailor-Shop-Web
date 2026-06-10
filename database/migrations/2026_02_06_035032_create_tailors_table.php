<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 20)->unique();
            $table->string('cnic', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('specialty', ['shalwar_kameez', 'sherwani', 'all'])->default('all');
            $table->enum('status', ['active', 'on_leave'])->default('active');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');

            // Cached work stats (kept in sync via Tailor::syncStats())
            $table->integer('total_orders_assigned')->default(0);
            $table->integer('total_suits_assigned')->default(0);
            $table->integer('orders_completed')->default(0);
            $table->integer('orders_pending')->default(0);

            // Cached payment stats
            $table->decimal('total_fee_earned', 12, 2)->default(0);
            $table->decimal('total_fee_received', 12, 2)->default(0);
            $table->decimal('total_fee_balance', 12, 2)->default(0);

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailors');
    }
};
