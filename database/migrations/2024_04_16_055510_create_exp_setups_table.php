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
        Schema::create('exp_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('auth_id');
            $table->integer('exp_id');
            $table->tinyInteger('vendor_id');
            $table->string('start_date');
            $table->string('interval_days');
            $table->string('end_date');
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exp_setups');
    }
};
