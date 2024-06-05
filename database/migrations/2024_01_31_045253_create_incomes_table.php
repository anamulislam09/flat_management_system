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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('auth_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('flat_id')->nullable();
            $table->string('flat_name')->nullable();
            $table->string('charge')->nullable();
            $table->double('amount', 20, 2)->default(0);
            $table->double('due', 20, 2)->default(0);
            $table->double('paid', 20, 2)->default(0);
            $table->bigInteger('status')->default(0);
            $table->string('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
