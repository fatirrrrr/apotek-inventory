<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;
use App\Models\Kategori;
use Carbon\Carbon;

class ObatSeeder extends Seeder
{
    public function run()
    {
        // Pastikan kategori sudah ada, atau buat contoh kategori dulu
        $kategori = Kategori::first() ?? Kategori::create([
            'nama_kategori' => 'Umum'
        ]);

        Obat::insert([
            [
                'nama' => 'Paracetamol',
                'harga' => 3000,
                'stok' => 100,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Amoxicillin',
                'harga' => 5000,
                'stok' => 80,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(8),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Antasida',
                'harga' => 4000,
                'stok' => 60,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cetirizine',
                'harga' => 3500,
                'stok' => 50,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Loperamide',
                'harga' => 2500,
                'stok' => 45,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Albendazole',
                'harga' => 7000,
                'stok' => 30,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(14),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Metformin',
                'harga' => 6000,
                'stok' => 90,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(11),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Simvastatin',
                'harga' => 5500,
                'stok' => 70,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(13),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Amlodipine',
                'harga' => 4800,
                'stok' => 55,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Omeprazole',
                'harga' => 8000,
                'stok' => 40,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(9),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ibuprofen',
                'harga' => 3500,
                'stok' => 65,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Captopril',
                'harga' => 4200,
                'stok' => 75,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(17),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Mefenamic Acid',
                'harga' => 3900,
                'stok' => 85,
                'kategori_id' => $kategori->id,
                'expired' => Carbon::now()->addMonths(16),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
