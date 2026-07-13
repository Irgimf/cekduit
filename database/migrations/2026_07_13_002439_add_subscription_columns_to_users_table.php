<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'premium', 'admin'])->default('user')->after('avatar');
            $table->enum('subscription_plan', ['free', 'monthly', 'yearly'])->default('free')->after('role');
            $table->timestamp('subscription_expires_at')->nullable()->after('subscription_plan');
            $table->string('midtrans_order_id')->nullable()->after('subscription_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'subscription_plan',
                'subscription_expires_at',
                'midtrans_order_id',
            ]);
        });
    }
};