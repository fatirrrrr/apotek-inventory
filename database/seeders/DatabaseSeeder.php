<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Obat;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@apotek.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Staff Apotek',
            'email' => 'staff@apotek.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        // Kategori
        $kategoris = [
            ['nama_kategori' => 'Obat Bebas', 'deskripsi' => 'Obat yang dapat dibeli tanpa resep dokter'],
            ['nama_kategori' => 'Obat Bebas Terbatas', 'deskripsi' => 'Obat dengan tanda peringatan khusus'],
            ['nama_kategori' => 'Obat Keras', 'deskripsi' => 'Obat yang memerlukan resep dokter'],
            ['nama_kategori' => 'Vitamin & Suplemen', 'deskripsi' => 'Vitamin dan suplemen kesehatan'],
            ['nama_kategori' => 'Obat Tradisional', 'deskripsi' => 'Obat herbal dan tradisional'],
        ];
        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // Ambil kategori_id untuk contoh data obat
        $kategori1 = Kategori::where('nama_kategori', 'Obat Bebas')->first();
        $kategori2 = Kategori::where('nama_kategori', 'Obat Keras')->first();

        // Obat
        $obats = [
            [
                'nama_obat' => 'Paracetamol 500mg',
                'kategori_id' => $kategori1->id ?? 1,
                'harga' => 5000,
                'stok' => 100,
                'expired' => '2025-12-31',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri'
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'kategori_id' => $kategori2->id ?? 2,
                'harga' => 15000,
                'stok' => 50,
                'expired' => '2025-08-15',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri'
            ],
            // dst...
        ];
        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
