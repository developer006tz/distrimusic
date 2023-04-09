<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_vendor', function (Blueprint $table) {
            $table
                ->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_vendor', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['vendor_id']);
        });
    }
};
