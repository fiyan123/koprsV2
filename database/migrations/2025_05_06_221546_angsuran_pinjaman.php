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
        Schema::create('angsuran_pinjaman', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pinjaman_id'); // relasi ke tabel pinjamans
        $table->unsignedBigInteger('user_id'); // relasi ke tabel users (opsional tapi disarankan)
        $table->integer('angsuran_ke'); // cicilan ke berapa
        $table->date('jatuh_tempo'); // tanggal jatuh tempo
        $table->date('tanggal_bayar')->nullable(); // tanggal bayar (boleh null kalau belum bayar)
        $table->decimal('jumlah_dibayar', 12, 2)->nullable(); // jumlah yang dibayar
        $table->decimal('denda', 12, 2)->default(0); // denda kalau telat bayar
        $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
        $table->string('bukti_transfer')->nullable();  // Kolom untuk path atau nama file bukti transfer

        $table->timestamps();

        // Foreign keys
        $table->foreign('pinjaman_id')->references('id')->on('pinjamans')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran_pinjaman');

    }
};
