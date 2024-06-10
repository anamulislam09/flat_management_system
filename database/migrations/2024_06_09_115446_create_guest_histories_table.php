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
        Schema::create('guest_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('guest_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('flat_id')->nullable();
            $table->text('purpose')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('exit_date')->nullable();
            $table->string('create_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_histories');
    }
};
