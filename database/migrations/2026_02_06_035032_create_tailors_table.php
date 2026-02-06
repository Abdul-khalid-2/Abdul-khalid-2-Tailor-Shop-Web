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
            $table->string('name');
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
            $table->string('phone', 20)->unique();
            $table->string('cnic', 15)->nullable()->unique();
            $table->string('address')->nullable();
            $table->json('specializations')->nullable();
            $table->enum('employment_type', ['permanent', 'contract', 'freelance'])->default('contract');
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->date('joining_date')->nullable();
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
