<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            // Statistik umum
            'total_obat' => Obat::count(),
            'total_kategori' => Kategori::count(),
            'total_transaksi' => Transaksi::count(),
            'total_user' => User::count(),

            // Obat dengan stok rendah (< 10)
            'obat_stok_rendah' => Obat::where('stok', '<=', 10)->count(),

            // Obat expired atau akan expired dalam 30 hari
            'obat_expired' => Obat::where('expired', '<', Carbon::now())->count(),
            'obat_akan_expired' => Obat::where('expired', '<=', Carbon::now()->addDays(30))
                ->where('expired', '>=', Carbon::now())
                ->count(),

            // Transaksi hari ini
            'transaksi_hari_ini' => Transaksi::whereDate('created_at', Carbon::today())->count(),
            'pendapatan_hari_ini' => Transaksi::whereDate('created_at', Carbon::today())->sum('total_harga'),

            // Transaksi bulan ini
            'transaksi_bulan_ini' => Transaksi::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'pendapatan_bulan_ini' => Transaksi::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_harga'),

            // Obat terlaris (top 5)
            'obat_terlaris' => Transaksi::with('obat')
                ->selectRaw('obat_id, SUM(jumlah) as total_terjual')
                ->groupBy('obat_id')
                ->orderBy('total_terjual', 'desc')
                ->limit(5)
                ->get(),

            // Transaksi terbaru (5 terakhir)
            'transaksi_terbaru' => Transaksi::with(['obat', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return view('dashboard', compact('data'));
    }
}
