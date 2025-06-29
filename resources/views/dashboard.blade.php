@extends('layouts.app')

@section('title', 'Dashboard - Sistem Inventaris Apotek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </h2>
            <div class="text-muted">
                <i class="bi bi-calendar-date me-1"></i>
                {{ date('d F Y') }}
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards Row 1 -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 text-white-50">Total Obat</h6>
                        <h3 class="mb-0">{{ number_format($data['total_obat']) }}</h3>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-capsule fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 text-white-50">Total Kategori</h6>
                        <h3 class="mb-0">{{ number_format($data['total_kategori']) }}</h3>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-tags fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 text-white-50">Total Transaksi</h6>
                        <h3 class="mb-0">{{ number_format($data['total_transaksi']) }}</h3>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-receipt fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 text-white-50">Total User</h6>
                        <h3 class="mb-0">{{ number_format($data['total_user']) }}</h3>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Cards Row 2 -->  
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card border-danger">
            <div class="card-body text-center">
                <div class="text-danger mb-2">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                </div>
                <h5 class="card-title text-danger">Stok Rendah</h5>
                <h3 class="text-danger">{{ number_format($data['obat_stok_rendah']) }}</h3>
                <p class="text-muted small mb-0">Obat dengan stok ≤ 10</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card border-danger">
            <div class="card-body text-center">
                <div class="text-danger mb-2">
                    <i class="bi bi-calendar-x fs-1"></i>
                </div>
                <h5 class="card-title text-danger">Expired</h5>
                <h3 class="text-danger">{{ number_format($data['obat_expired']) }}</h3>
                <p class="text-muted small mb-0">Obat sudah expired</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <div class="text-warning mb-2">
                    <i class="bi bi-clock-history fs-1"></i>
                </div>
                <h5 class="card-title text-warning">Akan Expired</h5>
                <h3 class="text-warning">{{ number_format($data['obat_akan_expired']) }}</h3>
                <p class="text-muted small mb-0">Dalam 30 hari</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <div class="text-info mb-2">
                    <i class="bi bi-calendar-check fs-1"></i>
                </div>
                <h5 class="card-title text-info">Transaksi Hari Ini</h5>
                <h3 class="text-info">{{ number_format($data['transaksi_hari_ini']) }}</h3>
                <p class="text-muted small mb-0">Rp {{ number_format($data['pendapatan_hari_ini'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Pendapatan & Transaksi -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-cash-coin me-2"></i>Pendapatan Bulan Ini
                </h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-success mb-2">
                    Rp {{ number_format($data['pendapatan_bulan_ini'], 0, ',', '.') }}
                </h2>
                <p class="text-muted mb-0">
                    Dari {{ number_format($data['transaksi_bulan_ini']) }} transaksi
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up me-2"></i>Obat Terlaris
                </h5>
            </div>
            <div class="card-body">
                @if($data['obat_terlaris']->count() > 0)
                    @foreach($data['obat_terlaris'] as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-medium">{{ $item->obat->nama_obat ?? 'Obat Dihapus' }}</span>
                            <span class="badge bg-primary">{{ number_format($item->total_terjual) }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0">Belum ada data penjualan</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>Transaksi Terbaru
                </h5>
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($data['transaksi_terbaru']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Obat</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['transaksi_terbaru'] as $transaksi)
                                    <tr>
                                        <td>
                                            <span class="text-muted">
                                                {{ $transaksi->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $transaksi->obat->nama_obat ?? 'Obat Dihapus' }}
                                        </td>
                                        <td>{{ number_format($transaksi->jumlah) }}</td>
                                        <td class="fw-bold text-success">
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $transaksi->user->name ?? 'User Dihapus' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection