<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('account_number')->nullable()->after('type'); // no rek/no hp
            $table->decimal('admin_fee', 15, 2)->default(0)->after('account_number'); // admin/bulan
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['account_number', 'admin_fee']);
        });
    }
};