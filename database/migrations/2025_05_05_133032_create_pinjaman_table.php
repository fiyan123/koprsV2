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
            $table->unsignedBigInteger('user_id'); // relasi ke users
            $table->string('nama');
            $table->text('alamat');
            $table->string('nip', 20);
            $table->decimal('jumlah', 12, 2);                         // total pinjaman
            $table->integer('durasi');                                // durasi dalam bulan
            $table->decimal('bunga', 5, 2);                           // bunga dalam persen, misal 2.5
            $table->decimal('angsuran_per_bulan', 12, 2)->nullable(); // bisa dihitung otomatis
            $table->decimal('total_bayar', 12, 2)->nullable();        // hasil dari angsuran * durasi
            $table->string('no_rek');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key
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
