<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);

    }

    protected $fillable = [
        'nama_menu',
        'harga',
        'vendor_id'
    ];
}
