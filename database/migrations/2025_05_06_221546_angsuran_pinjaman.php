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
            $table->unsignedBigInteger('user_id'); // redundan untuk efisiensi tracking
            $table->integer('angsuran_ke'); // cicilan ke berapa
            $table->date('tanggal_bayar'); // tanggal pembayaran
            $table->decimal('jumlah_dibayar', 12, 2); // jumlah uang dibayar
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
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
