<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add database-level replay protection for payment creation.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->string('idempotency_key', 100)
                ->unique()
                ->after('reference');
        });
    }

    /**
     * Remove payment idempotency protection.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->dropUnique(['idempotency_key']);
            $table->dropColumn('idempotency_key');
        });
    }
};
