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
        Schema::create('saldos', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('jumlah_saldo');  // Menyimpan jumlah saldo sebagai big integer
        $table->enum('type_saldo', ['saldo_simpanan', 'saldo_pinjaman', 'saldo_koperasi']);  // Tipe saldo
        $table->enum('status_saldo', ['pengeluaran', 'pemasukan']);  // Status saldo: pemasukan atau pengeluaran
        $table->text('description')->nullable();  // Deskripsi optional
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldos');
    }
};
