<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('users_id'); 
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id'); 
            $table->timestamps();

            // Relasi Foreign Key
            $table->foreign('role_id')
                  ->references('id')->on('role')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};