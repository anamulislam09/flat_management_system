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
        Schema::create('exp_processes', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('month');
            $table->double('total', 20, 2)->default(0);
            $table->integer('client_id');
            $table->string('auth_id');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exp_processes');
    }
};
