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
    $table->unsignedBigInteger('pinjaman_id');
    $table->integer('bulan_ke');                        // Bulan ke-1, ke-2, dst
    $table->date('jatuh_tempo');                        // tanggal jatuh tempo
    $table->decimal('jumlah_tagihan', 12, 2);           // angsuran per bulan
    $table->decimal('jumlah_denda', 12, 2)->default(0); // denda jika telat
    $table->decimal('total_bayar', 12, 2)->nullable();  // total = tagihan + denda
    $table->date('tanggal_bayar')->nullable();          // tanggal bayar aktual
    $table->enum('status', ['belum', 'dibayar', 'terlambat'])->default('belum');
    $table->timestamps();

    $table->foreign('pinjaman_id')->references('id')->on('pinjamans')->onDelete('cascade');
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
