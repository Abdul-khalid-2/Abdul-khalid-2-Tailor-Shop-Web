<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20)->index();
            $table->text('address')->nullable();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
            $table->string('reference')->nullable();

            $table->string('customer_type')->default('regular');
            $table->decimal('discount_rate', 5, 2)->default(0);
            $table->string('occupation')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->string('profile_photo')->nullable();
            $table->json('preferred_communication')->nullable();
            $table->boolean('send_welcome_message')->default(false);

            $table->text('notes')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index('customer_type');
            $table->index('discount_rate');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone_normalized', 20)->storedAs(
                "REGEXP_REPLACE(phone, '[^0-9]', '')"
            )->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
