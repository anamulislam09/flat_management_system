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
        Schema::create('expense_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_id');
            $table->string('month');
            $table->integer('year');
            $table->string('date');
            $table->integer('client_id');
            $table->string('auth_id');
            $table->integer('cat_id')->nullable();
            $table->double('amount', 20, 2)->default(0);
            $table->integer('vendor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_vouchers');
    }
};
