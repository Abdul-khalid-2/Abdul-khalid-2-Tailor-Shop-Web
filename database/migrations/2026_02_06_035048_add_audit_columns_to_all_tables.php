<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
