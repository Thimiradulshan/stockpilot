<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add a database-level whitelist for stock movement types.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            "ALTER TABLE stock_movements
             ADD CONSTRAINT stock_movements_movement_type_check
             CHECK (
                 movement_type IN (
                     'purchase',
                     'sale',
                     'adjustment',
                     'return',
                     'correction'
                 )
             )"
        );
    }

    /**
     * Remove the stock movement type whitelist.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            'ALTER TABLE stock_movements
             DROP CHECK stock_movements_movement_type_check'
        );
    }
};
