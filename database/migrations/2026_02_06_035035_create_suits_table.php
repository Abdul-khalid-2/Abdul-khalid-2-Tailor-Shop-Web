<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('color', 80); // e.g. Green, Navy Blue
            $table->integer('quantity')->default(1);
            $table->decimal('stitching_charge', 10, 2)->default(0);
            $table->decimal('button_charge', 10, 2)->default(0);
            $table->decimal('other_charge', 10, 2)->default(0);
            $table->string('other_charge_note', 200)->nullable();
            $table->decimal('suit_total', 10, 2)->default(0); // auto: (stitch+btn+other)*qty
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suits');
    }
};
