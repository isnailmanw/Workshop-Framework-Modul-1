<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagHarga extends Model
{
    // 🔥 GANTI KE TABEL BARANG
    protected $table = 'barang';

    // 🔥 SESUAIKAN DENGAN DATABASE (dari screenshot kamu: id integer)
    protected $primaryKey = 'id';

    // 🔥 karena id integer auto increment
    public $incrementing = true;

    protected $keyType = 'int';

    // 🔥 kalau tabel barang tidak pakai created_at & updated_at
    public $timestamps = false;

    // 🔥 SESUAIKAN NAMA FIELD DI DATABASE
    protected $fillable = [
        'nama',
        'harga'
    ];
}