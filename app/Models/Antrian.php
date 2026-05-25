<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'nomor_antrian',
        'nama_pengunjung',
        'status',
        'loket',
        'poli_id'
    ];

    public $timestamps = false;

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}