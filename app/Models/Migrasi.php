<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migrasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_kode',
        'tanggal',
        'jenis_mutasi_id',
        'jumlah',
    ];

    /**
     * Get the user that owns the migrasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the barang that is associated with the migrasi.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_kode', 'id');
    }

    public function jenis_mutasi()
    {
        return $this->belongsTo(JenisMutasi::class, 'jenis_mutasi_id', 'id');
    }
}
