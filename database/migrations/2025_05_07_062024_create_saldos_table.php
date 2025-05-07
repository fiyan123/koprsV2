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
            $table->decimal('jumlah_saldo', 18, 2);
            $table->enum('type_saldo', ['saldo_simpanan', 'saldo_pinjaman', 'saldo_koperasi']);
            $table->enum('status_saldo', ['pengeluaran', 'pemasukan']);
            $table->text('description')->nullable();
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
