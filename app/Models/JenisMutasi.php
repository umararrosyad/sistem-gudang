<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jenis_mutasi',
    ];

    public function migrasis()
    {
        return $this->hasMany(Migrasi::class, 'jenis_mutasi_id','id');
    }
}
