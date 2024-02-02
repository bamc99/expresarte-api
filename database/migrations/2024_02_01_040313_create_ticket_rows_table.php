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
        Schema::create('ticket_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->time('start_time')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->double('price');
            $table->integer('quantity');
            $table->integer('quantity_used');
            $table->double('discount')->default(0);
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_rows');
    }
};
