<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // 🔥 biar bisa insert massal (create)
    protected $fillable = [
        'nama',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kodepos',
        'foto_blob',
        'foto_path'
    ];
}