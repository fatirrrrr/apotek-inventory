<?php
// app/Http/Controllers/ObatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Kategori;

class ObatController extends Controller
{
    // Tampilkan daftar obat
    public function index()
    {
        $obats = Obat::with('kategori')->paginate(10);
        return view('obat.index', compact('obats'));
    }

    // Tampilkan form tambah obat
    public function create()
    {
        $kategoris = Kategori::all();
        return view('obat.create', compact('kategoris'));
    }

    // Simpan obat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'expired' => 'required|date|after:today',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh negatif',
            'expired.required' => 'Tanggal expired wajib diisi',
            'expired.date' => 'Format tanggal tidak valid',
            'expired.after' => 'Tanggal expired harus setelah hari ini',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    // Tampilkan form edit obat
    public function edit(Obat $obat)
    {
        $kategoris = Kategori::all();
        return view('obat.edit', compact('obat', 'kategoris'));
    }

    // Update obat
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'expired' => 'required|date',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh negatif',
            'expired.required' => 'Tanggal expired wajib diisi',
            'expired.date' => 'Format tanggal tidak valid',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    // Hapus obat
    public function destroy(Obat $obat)
    {
        // Cek apakah obat sudah digunakan dalam transaksi
        if ($obat->transaksis()->count() > 0) {
            return redirect()->route('obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena sudah digunakan dalam transaksi');
        }

        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    // Get obat data untuk AJAX (untuk transaksi)
    public function getObatData($id)
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $obat->id,
            'nama_obat' => $obat->nama_obat,
            'harga' => $obat->harga,
            'stok' => $obat->stok,
        ]);
    }
}
