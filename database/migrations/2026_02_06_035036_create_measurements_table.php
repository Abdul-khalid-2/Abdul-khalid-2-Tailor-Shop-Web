<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->onDelete('cascade');
            $table->decimal('length', 5, 1)->nullable();
            $table->decimal('shoulder', 5, 1)->nullable();
            $table->decimal('chest', 5, 1)->nullable();
            $table->decimal('waist', 5, 1)->nullable();
            $table->decimal('hip', 5, 1)->nullable();
            $table->decimal('sleeve', 5, 1)->nullable();
            $table->decimal('collar', 5, 1)->nullable();
            $table->decimal('trouser_length', 5, 1)->nullable();
            $table->decimal('trouser_waist', 5, 1)->nullable();
            $table->decimal('thigh', 5, 1)->nullable();
            $table->decimal('bottom_opening', 5, 1)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
