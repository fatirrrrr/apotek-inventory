<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Obat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User seeding (sama)
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

        // Kategori seeding
        $kategoris = [
            ['nama' => 'Obat Bebas', 'deskripsi' => 'Obat yang dapat dibeli tanpa resep dokter'],
            ['nama' => 'Obat Bebas Terbatas', 'deskripsi' => 'Obat dengan tanda peringatan khusus'],
            ['nama' => 'Obat Keras', 'deskripsi' => 'Obat yang memerlukan resep dokter'],
            ['nama' => 'Vitamin & Suplemen', 'deskripsi' => 'Vitamin dan suplemen kesehatan'],
            ['nama' => 'Obat Tradisional', 'deskripsi' => 'Obat herbal dan tradisional'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $obats = [
            [
                'nama' => 'Paracetamol 500mg',
                'kategori_id' => 1,
                'harga' => 5000,
                'stok' => 100,
                'expired' => '2025-12-31',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri'
            ],
            [
                'nama' => 'Amoxicillin 500mg',
                'kategori_id' => 3,
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
