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
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->decimal('height', 5, 1)->nullable();
            $table->decimal('weight', 5, 1)->nullable();
            $table->decimal('shoulder', 5, 1)->nullable();
            $table->decimal('chest', 5, 1)->nullable();
            $table->decimal('waist', 5, 1)->nullable();
            $table->decimal('hips', 5, 1)->nullable();
            $table->decimal('sleeve_length', 5, 1)->nullable();
            $table->decimal('sleeve_width', 5, 1)->nullable();
            $table->decimal('collar', 5, 1)->nullable();
            $table->decimal('bicep', 5, 1)->nullable();
            $table->decimal('wrist', 5, 1)->nullable();
            $table->decimal('pant_length', 5, 1)->nullable();
            $table->decimal('inseam', 5, 1)->nullable();
            $table->decimal('thigh', 5, 1)->nullable();
            $table->decimal('knee', 5, 1)->nullable();
            $table->decimal('bottom', 5, 1)->nullable();
            $table->decimal('ankle', 5, 1)->nullable();
            $table->json('additional_measurements')->nullable();
            $table->text('notes')->nullable();
            $table->text('fitting_preferences')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_current')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
