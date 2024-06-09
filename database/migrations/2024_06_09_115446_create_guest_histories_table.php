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
            $table->integer('client_id')->nullable();
            $table->string('flat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->text('purpose')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('exit_date')->nullable();
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
