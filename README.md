# Sistem Manajemen Inventaris Apotek Lokal

Aplikasi **sederhana** berbasis Laravel 12 untuk mengelola inventaris, penjualan, dan laporan apotek lokal.

## 🚀 Fitur Utama

- Login manual (tanpa Laravel UI/Jetstream)
- Session-based login
- Manajemen role: `admin` & `staff`
- Middleware kontrol akses role
- Layout konsisten (sidebar & header include)
- **CRUD Obat** (nama, harga, stok, kategori, expired)
- **CRUD Kategori**
- **Transaksi penjualan** (stok otomatis berkurang)
- **Dashboard statistik** obat & penjualan
- **Export laporan** ke PDF & Excel

## 🧰 Teknologi

- Laravel 12
- Blade Templates + Bootstrap 5
- DomPDF & Laravel Excel
- MySQL

## 📦 Instalasi

1. **Clone repo**
    ```sh
    git clone https://github.com/fatirrrrr/apotek-inventory.git
    cd apotek-inventory
    ```

2. **Install dependency**
    ```sh
    composer install
    npm install && npm run build # Jika menggunakan asset npm
    ```

3. **Copy dan edit file environment**
    ```sh
    cp .env.example .env
    # Edit .env sesuai koneksi database Anda
    ```

4. **Generate key**
    ```sh
    php artisan key:generate
    ```

5. **Migrasi database**
    ```sh
    php artisan migrate
    ```

6. **(Opsional) Seed user admin**
    - Buat user admin manual atau via seeder (jika tersedia).

7. **Jalankan server**
    ```sh
    php artisan serve
    ```

8. **Akses aplikasi**
    - Buka [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 👤 Role & Hak Akses

| Fitur                | Admin | Staff |
|----------------------|:-----:|:-----:|
| CRUD Obat/Kategori   |   ✔   |   ✖   |
| Transaksi Penjualan  |   ✔   |   ✔   |
| Hapus Transaksi      |   ✔   |   ✖   |
| Export Laporan       |   ✔   |   ✖   |
| Lihat Dashboard      |   ✔   |   ✔   |

## 📋 Struktur Folder Penting

```
/app/Http/Controllers
/app/Models
/database/migrations
/resources/views
/routes/web.php
```

## 📄 Lisensi

MIT. Silakan digunakan dan dikembangkan lebih lanjut.

---

**Saran:**  
Jaga file `.env` dan `/vendor` agar **tidak ikut terupload** ke GitHub!
