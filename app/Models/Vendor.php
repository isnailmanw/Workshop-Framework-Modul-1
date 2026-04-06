<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    protected $fillable = [
        'nama_vendor',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
