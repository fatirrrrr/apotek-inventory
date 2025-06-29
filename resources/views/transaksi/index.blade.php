@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-receipt me-2"></i>Riwayat Transaksi
                    </h5>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Transaksi Baru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter dan Pencarian -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <form method="GET" action="{{ route('transaksi.index') }}">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           placeholder="Cari kode transaksi atau nama obat..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <form method="GET" action="{{ route('transaksi.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select name="tanggal" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Tanggal</option>
                                    <option value="today" {{ request('tanggal') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="week" {{ request('tanggal') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ request('tanggal') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3 text-md-end text-start">
                            <div class="btn-group" role="group">
                                @if(auth()->user()->role === 'admin')
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="exportExcel()">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="exportPDF()">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                    </button>
                                @endif
                            </div>  
                        </div>
                    </div>

                    <!-- Statistik Ringkas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Transaksi</h6>
                                            <h4 class="mb-0">{{ $totalTransaksi }}</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-receipt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Penjualan</h6>
                                            <h4 class="mb-0">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-money-bill-wave fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Hari Ini</h6>
                                            <h4 class="mb-0">{{ $transaksiHariIni }}</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar-day fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Rata-rata/Hari</h6>
                                            <h4 class="mb-0">Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chart-line fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Transaksi -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
                                    <th>Kasir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi as $key => $item)
                                    <tr>
                                        <td>{{ $transaksi->firstItem() + $key }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->kode_transaksi }}</span>
                                        </td>
                                        <td>
                                            {{ $item->tanggal_transaksi ? \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            <strong>{{ $item->obat->nama_obat }}</strong>
                                            @if($item->obat->expired && $item->obat->expired < now()->addDays(30))
                                                <span class="badge bg-warning text-dark ms-1">Segera Expired</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->obat->kategori->nama_kategori }}</span>
                                        </td>
                                        <td>{{ $item->jumlah }} {{ $item->obat->satuan ?? 'pcs' }}</td>
                                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td>
                                            <strong class="text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info" 
                                                        onclick="showDetail({{ $item->id }})"
                                                        title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary" 
                                                        onclick="printReceipt({{ $item->id }})"
                                                        title="Cetak Struk">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <p>Belum ada data transaksi</p>
                                                <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Buat Transaksi Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($transaksi->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $transaksi->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Detail akan dimuat via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

function printReceipt(id) {
    window.open(`{{ url('transaksi/print') }}/${id}`, '_blank');
}

function exportExcel() {
    const search = '{{ request("search") }}';
    const tanggal = '{{ request("tanggal") }}';
    let url = '{{ route("transaksi.export.excel") }}';

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (tanggal) params.append('tanggal', tanggal);

    if (params.toString()) {
        url += '?' + params.toString();
    }

    window.open(url, '_blank');
}

function exportPDF() {
    const search = '{{ request("search") }}';
    const tanggal = '{{ request("tanggal") }}';
    let url = '{{ route("transaksi.export.pdf") }}';

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (tanggal) params.append('tanggal', tanggal);

    if (params.toString()) {
        url += '?' + params.toString();
    }

    window.open(url, '_blank');
}

// Auto-hide alert setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection