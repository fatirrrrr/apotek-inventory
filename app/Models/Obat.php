<?php
// app/Models/Obat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'harga',
        'stok',
        'expired',
        'kategori_id',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'expired' => 'date',
            'harga' => 'decimal:2',
        ];
    }

    // Relasi
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Helper methods
    public function isExpired()
    {
        return $this->expired < Carbon::now();
    }

    public function isExpiringSoon($days = 30)
    {
        return $this->expired <= Carbon::now()->addDays($days);
    }

    public function isOutOfStock()
    {
        return $this->stok <= 0;
    }

    public function isLowStock($threshold = 10)
    {
        return $this->stok <= $threshold;
    }
}
