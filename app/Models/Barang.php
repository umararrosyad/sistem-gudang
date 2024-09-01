<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
    ];

    /**
     * Get the migrasis for the barang.
     */
    public function migrasis()
    {
        return $this->hasMany(Migrasi::class, 'barang_kode', 'kode');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id','id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id','id');
    }
}
