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
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->enum('type', ['cashier', 'main', 'bank'])->default('cashier')->after('name');
            $table->foreignId('bank_id')->nullable()->after('agency_id')->constrained('banks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropColumn(['type', 'bank_id']);
        });
    }
};
