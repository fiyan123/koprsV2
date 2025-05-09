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
            $table->string('email');
            $table->date('tgl_lahir'); // gunakan tipe date untuk tanggal lahir
            $table->string('nip'); // asumsi NIP harus unik
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('no_rek')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['simpan', 'tarik','potong']);
            // $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela', 'berjangka']);
            $table->string('bukti_tf')->nullable();
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
