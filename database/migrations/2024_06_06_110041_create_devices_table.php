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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('mac_address');
            $table->string('box_number');
            $table->timestamp('registered_at');
            $table->timestamp('sold_at')->nullable();
            $table->foreignId('branch_id')->constrained('branches')->references('id')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
