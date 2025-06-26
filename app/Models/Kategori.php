<?php
// app/Models/Kategori.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    // Relasi
    public function obats()
    {
        return $this->hasMany(Obat::class);
    }
}
