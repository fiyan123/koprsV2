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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // $table->string('nip')->unique()->nullable();
            // $table->text('alamat')->nullable();
            // $table->string('no_ktp', 50)->unique();
            // $table->date('tgl_lahir')->nullable();
            // $table->string('no_hp', 20)->unique();
            // $table->string('foto')->nullable();
            // $table->string('foto_ktp')->nullable();
            // $table->string('foto_dengan_ktp')->nullable();
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
