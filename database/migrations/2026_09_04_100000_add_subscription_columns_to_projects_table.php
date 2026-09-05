<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('subscription_type')->nullable()->after('end_date');
            $table->unsignedBigInteger('subscription_price')->default(0)->after('subscription_type');
            $table->date('subscription_start')->nullable()->after('subscription_price');
            $table->date('subscription_expired')->nullable()->after('subscription_start');
            $table->string('subscription_status')->default('aktif')->after('subscription_expired');
            $table->boolean('auto_renew')->default(false)->after('subscription_status');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_type',
                'subscription_price',
                'subscription_start',
                'subscription_expired',
                'subscription_status',
                'auto_renew',
            ]);
        });
    }
};
