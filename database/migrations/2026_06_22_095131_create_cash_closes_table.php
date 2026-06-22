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
        Schema::create('cash_closes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('close_date');
            
            // Situation Compte
            $table->decimal('account_initial_balance', 15, 2)->default(0);
            $table->decimal('account_provisioning', 15, 2)->default(0);
            $table->decimal('account_payments', 15, 2)->default(0);
            $table->decimal('account_deposits', 15, 2)->default(0);
            $table->decimal('account_outputs', 15, 2)->default(0);
            $table->decimal('account_variance', 15, 2)->default(0);
            $table->decimal('account_final_balance', 15, 2)->default(0);
            
            // Situation Caisse
            $table->decimal('cash_initial_balance', 15, 2)->default(0);
            $table->decimal('cash_provisioning', 15, 2)->default(0);
            $table->decimal('cash_deposits', 15, 2)->default(0);
            $table->decimal('cash_payments', 15, 2)->default(0);
            $table->decimal('cash_outputs', 15, 2)->default(0);
            $table->decimal('cash_variance', 15, 2)->default(0);
            $table->decimal('cash_final_balance', 15, 2)->default(0);
            $table->integer('transaction_count')->default(0);
            
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('observations')->nullable();
            $table->boolean('is_historical')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_closes');
    }
};
