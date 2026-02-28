<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagHarga extends Model
{
    protected $table = 'tag_harga';

    protected $primaryKey = 'id_barang';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nama_barang',
        'harga'
    ];
}