<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'obat_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'nama_pembeli',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'harga_satuan' => 'decimal:2',
            'total_harga' => 'decimal:2',
        ];
    }

    // Relasi
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto generate kode transaksi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            if (empty($transaksi->kode_transaksi)) {
                $transaksi->kode_transaksi = 'TRX-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}