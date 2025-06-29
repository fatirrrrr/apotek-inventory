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
        $kategoriBebas = Kategori::where('nama_kategori', 'Obat Bebas')->first();
        $kategoriBebasTerbatas = Kategori::where('nama_kategori', 'Obat Bebas Terbatas')->first();
        $kategoriKeras = Kategori::where('nama_kategori', 'Obat Keras')->first();
        $kategoriVitamin = Kategori::where('nama_kategori', 'Vitamin & Suplemen')->first();
        $kategoriTradisional = Kategori::where('nama_kategori', 'Obat Tradisional')->first();

        // Obat
        $obats = [
            // Obat Bebas
            [
                'nama_obat' => 'Paracetamol 500mg',
                'kategori_id' => $kategoriBebas->id,
                'harga' => 5000,
                'stok' => 100,
                'expired' => '2025-12-31',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri'
            ],
            [
                'nama_obat' => 'Antasida Tablet',
                'kategori_id' => $kategoriBebas->id,
                'harga' => 3000,
                'stok' => 80,
                'expired' => '2025-11-30',
                'deskripsi' => 'Obat untuk mengatasi maag dan asam lambung'
            ],
            [
                'nama_obat' => 'CTM 4mg',
                'kategori_id' => $kategoriBebas->id,
                'harga' => 2000,
                'stok' => 70,
                'expired' => '2025-10-31',
                'deskripsi' => 'Obat alergi dan gatal-gatal'
            ],

            // Obat Bebas Terbatas
            [
                'nama_obat' => 'Ibuprofen 200mg',
                'kategori_id' => $kategoriBebasTerbatas->id,
                'harga' => 4500,
                'stok' => 60,
                'expired' => '2025-09-30',
                'deskripsi' => 'Obat anti-inflamasi dan pereda nyeri'
            ],
            [
                'nama_obat' => 'Dextromethorphan',
                'kategori_id' => $kategoriBebasTerbatas->id,
                'harga' => 3500,
                'stok' => 50,
                'expired' => '2025-12-01',
                'deskripsi' => 'Obat batuk kering'
            ],

            // Obat Keras
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'kategori_id' => $kategoriKeras->id,
                'harga' => 15000,
                'stok' => 50,
                'expired' => '2025-08-15',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri'
            ],
            [
                'nama_obat' => 'Cefadroxil 500mg',
                'kategori_id' => $kategoriKeras->id,
                'harga' => 18000,
                'stok' => 40,
                'expired' => '2026-01-10',
                'deskripsi' => 'Antibiotik spektrum luas'
            ],
            [
                'nama_obat' => 'Clindamycin 150mg',
                'kategori_id' => $kategoriKeras->id,
                'harga' => 21000,
                'stok' => 35,
                'expired' => '2026-02-01',
                'deskripsi' => 'Antibiotik untuk infeksi berat'
            ],

            // Vitamin & Suplemen
            [
                'nama_obat' => 'Vitamin C 500mg',
                'kategori_id' => $kategoriVitamin->id,
                'harga' => 7000,
                'stok' => 90,
                'expired' => '2026-03-15',
                'deskripsi' => 'Vitamin C untuk daya tahan tubuh'
            ],
            [
                'nama_obat' => 'Vitamin D3 1000 IU',
                'kategori_id' => $kategoriVitamin->id,
                'harga' => 10000,
                'stok' => 60,
                'expired' => '2026-07-21',
                'deskripsi' => 'Vitamin D3 untuk kesehatan tulang'
            ],
            [
                'nama_obat' => 'Suplemen Zink',
                'kategori_id' => $kategoriVitamin->id,
                'harga' => 12000,
                'stok' => 55,
                'expired' => '2026-09-25',
                'deskripsi' => 'Suplemen zink untuk imunitas'
            ],

            // Obat Tradisional
            [
                'nama_obat' => 'Jamu Masuk Angin',
                'kategori_id' => $kategoriTradisional->id,
                'harga' => 8000,
                'stok' => 40,
                'expired' => '2026-12-01',
                'deskripsi' => 'Jamu herbal untuk masuk angin'
            ],
            [
                'nama_obat' => 'Minyak Kayu Putih',
                'kategori_id' => $kategoriTradisional->id,
                'harga' => 9000,
                'stok' => 30,
                'expired' => '2027-02-01',
                'deskripsi' => 'Minyak herbal untuk penghangat tubuh'
            ],
            [
                'nama_obat' => 'Tolak Angin Cair',
                'kategori_id' => $kategoriTradisional->id,
                'harga' => 9500,
                'stok' => 60,
                'expired' => '2027-03-15',
                'deskripsi' => 'Obat herbal cair untuk stamina'
            ],
        ];
        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
