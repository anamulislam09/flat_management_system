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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->nullable();
            $table->integer('client_id')->nullable();
            $table->string('flat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('nid_no')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('charge')->nullable();
            $table->double('amount',20, 2)->default(0); 
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('role_id')->default(0);
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
