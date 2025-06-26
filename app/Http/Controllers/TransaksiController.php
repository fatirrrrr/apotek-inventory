<?php
// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class TransaksiController extends Controller
{
    // Tampilkan daftar transaksi
    public function index(Request $request)
    {
        $query = Transaksi::with(['obat', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhereHas('obat', function ($obat) use ($search) {
                        $obat->where('nama_obat', 'like', '%' . $search . '%');
                    });
            });
        }
        if ($request->filled('tanggal')) {
            if ($request->tanggal == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->tanggal == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->tanggal == 'month') {
                $query->whereMonth('created_at', now()->month);
            }
        }

        $transaksi = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalTransaksi = Transaksi::count();
        $totalPenjualan = Transaksi::sum('total_harga');
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();

        $firstTransaksi = Transaksi::orderBy('created_at', 'asc')->first();
        $rataRataHarian = $firstTransaksi
            ? $totalPenjualan / (now()->diffInDays($firstTransaksi->created_at) + 1)
            : 0;

        return view('transaksi.index', compact(
            'transaksi',
            'totalTransaksi',
            'totalPenjualan',
            'transaksiHariIni',
            'rataRataHarian'
        ));
    }

    // Tampilkan form tambah transaksi
    public function create()
    {
        $obats = Obat::where('stok', '>', 0)->get();
        // Contoh generate kode transaksi unik (TRX20250626162500)
        $kodeTransaksi = 'TRX' . date('YmdHis');
        return view('transaksi.create', compact('obats', 'kodeTransaksi'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'nama_pembeli' => 'required|string|max:255',
        ], [
            'obat_id.required' => 'Obat wajib dipilih',
            'obat_id.exists' => 'Obat tidak valid',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'nama_pembeli.required' => 'Nama pembeli wajib diisi',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $obat = Obat::findOrFail($request->obat_id);

                // Cek stok tersedia
                if ($obat->stok < $request->jumlah) {
                    throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $obat->stok);
                }

                // Hitung total harga
                $harga_satuan = $obat->harga;
                $total_harga = $harga_satuan * $request->jumlah;

                // Simpan transaksi
                Transaksi::create([
                    'obat_id' => $request->obat_id,
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $harga_satuan,
                    'total_harga' => $total_harga,
                    'nama_pembeli' => $request->nama_pembeli,
                    'user_id' => Auth::id(), // Gunakan Auth::id() bukan auth()->id()
                ]);

                // Kurangi stok obat
                $obat->decrement('stok', $request->jumlah);
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Hapus transaksi (hanya admin)
    public function destroy(Transaksi $transaksi)
    {
        try {
            DB::transaction(function () use ($transaksi) {
                // Kembalikan stok obat
                $transaksi->obat->increment('stok', $transaksi->jumlah);

                // Hapus transaksi
                $transaksi->delete();
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus transaksi');
        }
    }

    // Export ke PDF
    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['obat', 'user']);

        // Apply filters
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();
        $total_pendapatan = $transaksis->sum('total_harga');

        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksis', 'total_pendapatan', 'request'));

        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }

    // Export ke Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new TransaksiExport($request), 'laporan-transaksi-' . date('Y-m-d') . '.xlsx');
    }
}
