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
            $table->id('id')->primary;
            $table->string('user_fullname', 100);
            $table->string('user_username', 50)->unique();
            $table->string('user_password', 255);
            $table->string('user_email', 50)->unique();
            $table->char('user_notelp', 14);
            $table->string('user_alamat', 200);
            $table->string('user_profil_url')->nullable(true);
            $table->enum('user_level', ['admin', 'pengguna'])->default('pengguna');
            $table->boolean('user_status')->default(true);
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
