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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('status')->default('open');

            $table->date('date_scheduled');
            $table->date('checked_in_at')->nullable();

            $table->foreignId('client_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->double('sub_total');
            $table->double('tip');
            $table->double('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
