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
        Schema::create('supply_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->enum('type', ['client', 'product', 'agency', 'central']);
            
            $table->foreignId('agency_source_id')->nullable()->constrained('agencies')->onDelete('cascade');
            $table->foreignId('agency_destination_id')->nullable()->constrained('agencies')->onDelete('cascade');
            
            $table->foreignId('service_source_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->foreignId('service_destination_id')->nullable()->constrained('services')->onDelete('cascade');
            
            $table->foreignId('cash_register_source_id')->nullable()->constrained('cash_registers')->onDelete('cascade');
            $table->foreignId('cash_register_destination_id')->nullable()->constrained('cash_registers')->onDelete('cascade');
            
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type', 'status']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_requests');
    }
};
