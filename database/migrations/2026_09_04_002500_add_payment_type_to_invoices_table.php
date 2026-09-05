<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'payment_type')) {
                $table->string('payment_type')->nullable()->default('full')->after('payment_method');
            }
            if (!Schema::hasColumn('invoices', 'payment_amount_transferred')) {
                $table->decimal('payment_amount_transferred', 15, 2)->nullable()->after('payment_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
            if (Schema::hasColumn('invoices', 'payment_amount_transferred')) {
                $table->dropColumn('payment_amount_transferred');
            }
        });
    }
};
