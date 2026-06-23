<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Supprimer les champs de validation
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approved_by', 'approved_at', 'rejection_reason']);
            
            // Ajouter les champs de rapprochement
            $table->foreignId('reconciled_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->timestamp('reconciled_at')->nullable()->after('reconciled_by');
            $table->text('reconciliation_notes')->nullable()->after('reconciled_at');
        });
        
        // Mettre à jour les statuts existants
        DB::statement("UPDATE transactions SET status = 'recorded' WHERE status = 'pending'");
        DB::statement("UPDATE transactions SET status = 'reconciled' WHERE status = 'approved'");
        DB::statement("UPDATE transactions SET status = 'discrepancy' WHERE status = 'rejected'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Supprimer les champs de rapprochement
            $table->dropForeign(['reconciled_by']);
            $table->dropColumn(['reconciled_by', 'reconciled_at', 'reconciliation_notes']);
            
            // Restaurer les champs de validation
            $table->foreignId('approved_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
        });
        
        // Restaurer les statuts
        DB::statement("UPDATE transactions SET status = 'pending' WHERE status = 'recorded'");
        DB::statement("UPDATE transactions SET status = 'approved' WHERE status = 'reconciled'");
        DB::statement("UPDATE transactions SET status = 'rejected' WHERE status = 'discrepancy'");
    }
};
