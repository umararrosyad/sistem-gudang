<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * Get the migrasis for the user.
     */
    public function migrasis()
    {
        return $this->hasMany(Migrasi::class, 'user_id', 'id');
    }
}
