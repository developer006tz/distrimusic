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
        Schema::table('order_service', function (Blueprint $table) {
            $table
                ->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_service', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['order_id']);
        });
    }
};
