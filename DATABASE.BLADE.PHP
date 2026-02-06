php artisan make:migration create_branches_table
php artisan make:migration create_lookup_tables 
php artisan make:migration create_dress_types_table
php artisan make:migration create_users_table
{{-- after users I have spaity-tables no neet to create spaity alray provide this  --}}
php artisan make:migration create_customers_table
php artisan make:migration create_tailors_table
php artisan make:migration create_orders_table
php artisan make:migration create_order_items_table
php artisan make:migration create_measurements_table
php artisan make:migration create_fabrics_table
php artisan make:migration create_tailor_assignments_table
php artisan make:migration create_payments_table
php artisan make:migration create_discounts_table
php artisan make:migration create_order_discounts_table
php artisan make:migration create_expenses_table
php artisan make:migration create_measurement_templates_table
php artisan make:migration create_order_status_logs_table
php artisan make:migration create_settings_table
php artisan make:migration add_audit_columns_to_all_tables
php artisan make:migration add_indexes_to_all_tables

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_phone', 20)->nullable();
            $table->string('manager_email')->nullable();
            $table->time('opening_time')->default('09:00:00');
            $table->time('closing_time')->default('18:00:00');
            $table->json('working_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('opening_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
```
## **1. products**
    Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();

            // fabric | readymade | accessory
            $table->enum('type', ['fabric', 'readymade', 'accessory']);

            $table->decimal('sale_price', 10, 2);
            $table->decimal('cost_price', 10, 2)->default(0);

            // fabric => meter, readymade => piece
            $table->string('unit')->default('piece');

            $table->decimal('stock_quantity', 10, 3)->default(0);

            $table->string('color')->nullable();
            $table->string('brand')->nullable();

            $table->foreignId('branch_id')->nullable()
                ->constrained('branches')->onDelete('set null');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });

## **2. create_lookup_tables.php**
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

        // Seed data
        DB::table('order_statuses')->insert([
            ['name' => 'Pending', 'slug' => 'pending', 'sort_order' => 1, 'color' => '#f59e0b'],
            ['name' => 'Confirmed', 'slug' => 'confirmed', 'sort_order' => 2, 'color' => '#3b82f6'],
            ['name' => 'In Progress', 'slug' => 'in-progress', 'sort_order' => 3, 'color' => '#8b5cf6'],
            ['name' => 'Ready', 'slug' => 'ready', 'sort_order' => 4, 'color' => '#10b981'],
            ['name' => 'Delivered', 'slug' => 'delivered', 'sort_order' => 5, 'color' => '#059669', 'is_completed' => true],
            ['name' => 'Cancelled', 'slug' => 'cancelled', 'sort_order' => 6, 'color' => '#ef4444', 'is_cancelled' => true],
        ]);

        DB::table('payment_statuses')->insert([
            ['name' => 'Pending', 'slug' => 'pending', 'sort_order' => 1, 'color' => '#f59e0b'],
            ['name' => 'Partial', 'slug' => 'partial', 'sort_order' => 2, 'color' => '#8b5cf6'],
            ['name' => 'Paid', 'slug' => 'paid', 'sort_order' => 3, 'color' => '#10b981', 'is_paid' => true],
            ['name' => 'Overdue', 'slug' => 'overdue', 'sort_order' => 4, 'color' => '#ef4444'],
        ]);

        DB::table('payment_methods')->insert([
            ['name' => 'Cash', 'slug' => 'cash', 'sort_order' => 1],
            ['name' => 'Credit Card', 'slug' => 'credit-card', 'sort_order' => 2],
            ['name' => 'Bank Transfer', 'slug' => 'bank-transfer', 'sort_order' => 3],
            ['name' => 'Mobile Payment', 'slug' => 'mobile-payment', 'sort_order' => 4],
        ]);

        DB::table('assignment_statuses')->insert([
            ['name' => 'Assigned', 'slug' => 'assigned', 'sort_order' => 1, 'color' => '#3b82f6'],
            ['name' => 'In Progress', 'slug' => 'in-progress', 'sort_order' => 2, 'color' => '#8b5cf6'],
            ['name' => 'Completed', 'slug' => 'completed', 'sort_order' => 3, 'color' => '#10b981', 'is_completed' => true],
            ['name' => 'Delayed', 'slug' => 'delayed', 'sort_order' => 4, 'color' => '#ef4444'],
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
```

## **3. create_dress_types_table.php**

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dress_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->integer('estimated_days')->default(7);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dress_types');
    }
};
```

## **4. create_users_table.php**

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'manager', 'staff', 'tailor'])->default('staff');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

## **5. create_customers_table.php**
```php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20)->index();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
            $table->text('address')->nullable();
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
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
```

## **6. create_tailors_table.php**
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
```

## **7. create_orders_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('restrict');
            $table->foreignId('status_id')->default(1)->constrained('order_statuses')->onDelete('restrict');
            $table->foreignId('payment_status_id')->default(1)->constrained('payment_statuses')->onDelete('restrict');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->date('estimated_date')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('advance_amount', 12, 2)->default(0);
            $table->decimal('remaining_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('order_type', ['tailoring', 'product', 'mixed'])->default('tailoring');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
```

## **8. create_order_items_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('dress_type_id')->nullable()->constrained('dress_types')->onDelete('restrict');
            $table->string('item_name')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('item_status', ['pending', 'cutting', 'stitching', 'ready', 'delivered'])->default('pending');
            $table->text('instructions')->nullable();
            $table->enum('item_type', ['tailoring', 'product'])->default('tailoring');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
```

## **9. create_measurements_table.php**
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
```

## **10. create_fabrics_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->string('fabric_code')->unique();
            $table->string('type'); // silk, cotton
            $table->string('color');
            $table->string('pattern')->nullable();
            $table->integer('gsm')->nullable();
            $table->text('description')->nullable();

            // Stock & Pricing
            $table->decimal('stock_meter', 10, 3);
            $table->decimal('min_stock_meter', 10, 3)->default(0);
            $table->decimal('purchase_rate', 10, 2);
            $table->decimal('selling_rate', 10, 2);

            // Supplier
            $table->string('supplier')->nullable();
            $table->string('supplier_reference')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('invoice_number')->nullable();

            // Properties
            $table->integer('width_inches')->nullable();
            $table->decimal('shrinkage', 5, 2)->nullable();
            $table->string('wash_care')->nullable();
            $table->json('suitable_for')->nullable();

            // Flags
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_imported')->default(false);
            $table->boolean('is_eco_friendly')->default(false);

            // Extra
            $table->string('storage_location')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();

            $table->foreignId('branch_id')->constrained()->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
```

## **11. create_tailor_assignments_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailor_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->foreignId('tailor_id')->constrained('tailors')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('assignment_statuses')->onDelete('restrict');
            $table->date('assign_date');
            $table->date('expected_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->decimal('stitching_charge', 10, 2);
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('remaining_payment', 10, 2)->default(0);
            $table->integer('progress_percentage')->default(0);
            $table->text('progress_notes')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('instructions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailor_assignments');
    }
};
```

## **12. create_payments_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict');
            $table->decimal('amount', 12, 2);
            $table->decimal('previous_balance', 12, 2)->default(0);
            $table->decimal('new_balance', 12, 2)->default(0);
            $table->date('payment_date');
            $table->string('transaction_id')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->text('description')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
```

## **13. create_discounts_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->enum('type', ['percentage', 'fixed', 'bogo'])->default('percentage');
            $table->decimal('value', 10, 2);
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->foreignId('applicable_dress_type_id')->nullable()->constrained('dress_types')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('for_new_customers')->default(false);
            $table->boolean('for_existing_customers')->default(true);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
```

## **14. create_order_discounts_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('discount_id')->constrained('discounts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_discounts');
    }
};
```

## **15. create_expenses_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('general');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->date('expense_date');
            $table->string('vendor')->nullable();
            $table->string('invoice_number')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('receipt_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
```

## **16. create_measurement_templates_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('dress_type_id')->constrained('dress_types')->onDelete('cascade');
            $table->string('template_name');
            $table->json('measurements');
            $table->text('notes')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_templates');
    }
};
```

## **17. create_order_status_logs_table.php**
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('old_status_id')->nullable()->constrained('order_statuses')->onDelete('set null');
            $table->foreignId('new_status_id')->constrained('order_statuses')->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_logs');
    }
};
```

## **18. create_settings_table.php**
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
```

## **19. add_audit_columns_to_all_tables.php**

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('dress_types', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('fabrics', function (Blueprint $table) {
            $table->index(['type', 'color']);
            $table->index(['status', 'branch_id']);
        });

        Schema::table('measurements', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('measurement_templates', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('order_statuses', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('payment_statuses', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('assignment_statuses', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        $tables = [
            'branches',
            'dress_types',
            'fabrics',
            'measurements',
            'measurement_templates',
            'order_statuses',
            'payment_statuses',
            'payment_methods',
            'assignment_statuses',
            'settings'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, 'created_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['created_by']);
                    $table->dropColumn('created_by');
                });
            }
            if (Schema::hasColumn($tableName, 'updated_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['updated_by']);
                    $table->dropColumn('updated_by');
                });
            }
        }
    }
};
```

## **20. add_indexes_to_all_tables.php**

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
    Schema::create('fabric_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fabric_id')->constrained('fabrics')->onDelete('cascade');
        $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('set null');
        $table->enum('type', ['purchase', 'cut', 'return', 'adjustment']);
        $table->decimal('meter', 8, 3);
        $table->decimal('rate', 8, 2);
        $table->decimal('total', 10, 2);
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamps();
    });