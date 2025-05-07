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
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke tabel users
            $table->string('nama');
            $table->text('alamat');
            $table->string('nip', 20)->unique(); // asumsi NIP harus unik
            $table->string('no_hp', 20);
            $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela', 'berjangka']); // jenis simpanan koperasi
            $table->decimal('jumlah', 12, 2);
            $table->string('bukti_tf')->nullable(); // bukti transfer opsional
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};
