<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldos'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'jumlah_saldo',
        'type_saldo',
        'status_saldo',
        'description',
    ];
}
