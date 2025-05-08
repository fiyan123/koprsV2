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
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke tabel users
            $table->string('nama');
            $table->date('tgl_lahir'); // gunakan tipe date untuk tanggal lahir
            $table->string('nip'); // biasanya NIP bersifat unik
            $table->string('email');
            $table->text('alamat');
            $table->string('no_rek');
            $table->decimal('jumlah', 12, 2); // pinjaman pokok
            $table->enum('tipe_durasi', ['harian', 'bulanan', 'tahunan']);
            $table->integer('durasi'); // durasi sesuai tipe
            $table->decimal('bunga', 5, 2); // persen bunga
            $table->decimal('total_bunga', 12, 2);
            $table->decimal('total_pembayaran', 12, 2);
            $table->decimal('cicilan_pembayaran', 12, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};
