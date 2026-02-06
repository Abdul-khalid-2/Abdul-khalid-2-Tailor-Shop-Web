php artisan make:migration create_branches_table
php artisan make:migration create_lookup_tables  # All statuses, payment methods
php artisan make:migration create_dress_types_table
php artisan make:migration create_users_table
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


public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'staff', 'tailor'])->default('staff');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('set null');
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


Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique();
    $table->foreignId('customer_id')->constrained()->onDelete('restrict'); // Don't cascade delete customers with orders
    $table->foreignId('branch_id')->constrained()->onDelete('restrict'); // Should not be nullable
    $table->foreignId('status_id')->default(1)->constrained('order_statuses')->onDelete('restrict');
    $table->foreignId('payment_status_id')->default(1)->constrained('payment_statuses')->onDelete('restrict');
    
    // Dates
    $table->date('order_date')->index();
    $table->date('delivery_date')->nullable()->index();
    $table->date('estimated_date')->nullable();
    
    // Financials
    $table->decimal('subtotal', 12, 2)->default(0); // Add subtotal
    $table->decimal('total_amount', 12, 2)->default(0);
    $table->decimal('advance_amount', 12, 2)->default(0);
    $table->decimal('remaining_amount', 12, 2)->storedAs('total_amount - advance_amount'); // Stored, not virtual
    $table->decimal('discount_amount', 10, 2)->default(0);
    $table->decimal('final_amount', 12, 2)->storedAs('total_amount - discount_amount');
    
    // Remove discount_id from here (handled in order_discounts)
    $table->text('notes')->nullable();
    $table->text('internal_notes')->nullable();
    
    // Audit
    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
    
    $table->timestamps();
    $table->softDeletes();
    
    // Composite indexes
    $table->index(['branch_id', 'status_id', 'order_date']);
    $table->index(['customer_id', 'order_date']);
    $table->index(['delivery_date', 'status_id']);
});


Schema::create('measurements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
    // Remove unique constraint to allow updates
    
    // Body Measurements
    $table->decimal('height', 5, 1)->nullable(); // 999.9 cm max
    $table->decimal('weight', 5, 1)->nullable(); // 999.9 kg max
    
    // Use consistent precision
    $table->decimal('shoulder', 5, 1)->nullable();
    $table->decimal('chest', 5, 1)->nullable();
    $table->decimal('waist', 5, 1)->nullable();
    $table->decimal('hips', 5, 1)->nullable();
    // ... other measurements
    
    // Versioning support
    $table->integer('version')->default(1);
    $table->boolean('is_current')->default(true);
    
    $table->json('additional_measurements')->nullable();
    $table->text('notes')->nullable();
    $table->text('fitting_preferences')->nullable();
    
    $table->timestamps();
    
    // Index for finding current measurements
    $table->index(['order_item_id', 'is_current']);
});


Schema::create('fabrics', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('cascade'); // Nullable
    $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade'); // Also link to order
    
    $table->string('fabric_type')->index();
    $table->string('color')->nullable()->index();
    $table->decimal('meter', 8, 3)->default(0); // Allow mm precision
    $table->decimal('rate_per_meter', 8, 2)->nullable();
    $table->decimal('fabric_cost', 10, 2)->storedAs('meter * COALESCE(rate_per_meter, 0)');
    
    $table->enum('status', ['pending', 'ordered', 'received', 'cut', 'delivered'])->default('pending');
    $table->date('expected_date')->nullable();
    $table->date('received_date')->nullable();
    $table->date('cutting_date')->nullable();
    
    $table->text('notes')->nullable();
    $table->string('supplier')->nullable();
    $table->string('supplier_invoice')->nullable();
    
    $table->timestamps();
    
    $table->index(['order_item_id', 'status']);
    $table->index(['fabric_type', 'color']);
});


// create_lookup_tables.php
Schema::create('order_statuses', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('slug')->unique();
    $table->string('color')->default('#6b7280');
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->boolean('is_completed')->default(false); // Flag for completed orders
    $table->boolean('is_cancelled')->default(false); // Flag for cancelled orders
    $table->timestamps();
});

// Pre-populate with common statuses
DB::table('order_statuses')->insert([
    ['name' => 'Pending', 'slug' => 'pending', 'sort_order' => 1, 'color' => '#f59e0b'],
    ['name' => 'Confirmed', 'slug' => 'confirmed', 'sort_order' => 2, 'color' => '#3b82f6'],
    ['name' => 'In Progress', 'slug' => 'in-progress', 'sort_order' => 3, 'color' => '#8b5cf6'],
    ['name' => 'Ready', 'slug' => 'ready', 'sort_order' => 4, 'color' => '#10b981'],
    ['name' => 'Delivered', 'slug' => 'delivered', 'sort_order' => 5, 'color' => '#059669', 'is_completed' => true],
    ['name' => 'Cancelled', 'slug' => 'cancelled', 'sort_order' => 6, 'color' => '#ef4444', 'is_cancelled' => true],
]);


// create_notifications_table.php
Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type');
    $table->morphs('notifiable');
    $table->json('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});

// create_audit_logs_table.php
Schema::create('audit_logs', function (Blueprint $table) {
    $table->id();
    $table->string('action'); // created, updated, deleted, etc.
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    $table->json('old_values')->nullable();
    $table->json('new_values')->nullable();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('ip_address', 45)->nullable();
    $table->string('user_agent')->nullable();
    $table->timestamps();
    
    $table->index(['model_type', 'model_id']);
    $table->index(['action', 'created_at']);
});


// In add_indexes_to_all_tables.php
public function up(): void
{
    // Customers
    Schema::table('customers', function (Blueprint $table) {
        $table->index(['branch_id', 'created_at']);
        $table->index('phone_normalized');
        $table->fullText(['name', 'reference', 'notes']);
    });
    
    // Orders
    Schema::table('orders', function (Blueprint $table) {
        $table->index(['branch_id', 'status_id', 'order_date']);
        $table->index(['customer_id', 'status_id']);
        $table->index(['payment_status_id', 'delivery_date']);
        $table->index('order_number');
    });
    
    // Order Items
    Schema::table('order_items', function (Blueprint $table) {
        $table->index(['order_id', 'dress_type_id']);
        $table->index(['item_status', 'created_at']);
    });
    
    // Payments
    Schema::table('payments', function (Blueprint $table) {
        $table->index(['order_id', 'payment_date']);
        $table->index(['payment_method_id', 'payment_date']);
        $table->index('receipt_number');
    });
    
    // Tailor Assignments
    Schema::table('tailor_assignments', function (Blueprint $table) {
        $table->index(['tailor_id', 'status_id']);
        $table->index(['order_item_id', 'status_id']);
        $table->index(['assign_date', 'expected_date']);
    });
}
