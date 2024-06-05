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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('auth_id')->nullable();
            $table->integer('year');
            $table->string('month');
            $table->double('total_income', 20, 2)->default(0);
            $table->double('total_expense', 20, 2)->default(0);
            $table->double('amount', 20, 2)->default(0);
            $table->tinyInteger('flag');
            $table->string('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
