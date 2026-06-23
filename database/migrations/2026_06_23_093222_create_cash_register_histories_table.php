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
        Schema::create('cash_register_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_register_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->date('date');
            
            // Situation Compte
            $table->decimal('solde_initial_compte', 15, 2)->default(0);
            $table->decimal('approvisionnement_compte', 15, 2)->default(0);
            $table->decimal('paiements_compte', 15, 2)->default(0);
            $table->decimal('depots_clients_compte', 15, 2)->default(0);
            $table->decimal('sorties_compte', 15, 2)->default(0);
            $table->decimal('ecart_compte', 15, 2)->default(0);
            $table->decimal('solde_final_compte', 15, 2)->default(0);
            
            // Situation Caisse
            $table->decimal('solde_initial_caisse', 15, 2)->default(0);
            $table->decimal('approvisionnement_caisse', 15, 2)->default(0);
            $table->decimal('depots_clients_caisse', 15, 2)->default(0);
            $table->decimal('paiements_caisse', 15, 2)->default(0);
            $table->decimal('sorties_caisse', 15, 2)->default(0);
            $table->decimal('ecart_caisse', 15, 2)->default(0);
            $table->decimal('solde_final_caisse', 15, 2)->default(0);
            $table->integer('nombre_transactions')->default(0);
            
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['cash_register_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_register_histories');
    }
};
