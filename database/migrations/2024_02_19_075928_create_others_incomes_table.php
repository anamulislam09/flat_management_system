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
        Schema::create('others_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('year');
            $table->string('date');
            $table->integer('client_id')->nullable();
            $table->string('auth_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('income_info')->nullable();
            $table->double('amount', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('others_incomes');
    }
};
