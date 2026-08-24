<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('sla_response_due_at')->nullable()->after('status');
            $table->timestamp('sla_resolution_due_at')->nullable()->after('sla_response_due_at');
            $table->timestamp('first_response_at')->nullable()->after('technician_id');
            $table->timestamp('resolved_at')->nullable()->after('first_response_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'sla_response_due_at',
                'sla_resolution_due_at',
                'first_response_at',
                'resolved_at',
            ]);
        });
    }
};
