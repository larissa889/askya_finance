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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // e.g. TXN-20260620-0001
            $table->foreignId('agency_id')->constrained('agencies')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            // Client info
            $table->string('client_name');
            $table->string('phone_number');

            // Service & type
            $table->string('service_type'); // RIA, MoneyGram, Western Union, Internal
            $table->enum('transaction_type', ['send', 'receive']);

            // Financial fields
            $table->decimal('amount', 15, 2);
            $table->decimal('fees', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->storedAs('amount + fees');

            // Status
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');

            // Optional notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for query performance
            $table->index(['agency_id', 'created_at']);
            $table->index(['created_by', 'status']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
