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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('agency_id')->nullable()->constrained()->onDelete('set null')->after('id');
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('id_number')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('role');
            $table->softDeletes();
            
            // Rendre le champ name nullable car il sera calculé automatiquement
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['agency_id']);
            $table->dropColumn(['agency_id', 'first_name', 'last_name', 'phone', 'id_number', 'is_active']);
            $table->dropSoftDeletes();
            
            // Remettre le champ name comme non nullable
            $table->string('name')->nullable(false)->change();
        });
    }
};
