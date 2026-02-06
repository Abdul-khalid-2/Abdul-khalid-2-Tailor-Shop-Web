<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('cascade');
            $table->string('shop_name');
            $table->string('shop_phone', 20);
            $table->string('shop_email')->nullable();
            $table->text('shop_address')->nullable();
            $table->string('currency')->default('PKR');
            $table->string('currency_symbol')->default('Rs');
            $table->integer('default_delivery_days')->default(7);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->text('receipt_header')->nullable();
            $table->text('receipt_footer')->nullable();
            $table->string('receipt_prefix')->default('TS');
            $table->integer('next_receipt_number')->default(1000);
            $table->json('measurement_fields')->nullable();
            $table->json('dress_type_measurements')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('email_notifications')->default(false);
            $table->integer('reminder_days_before')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
