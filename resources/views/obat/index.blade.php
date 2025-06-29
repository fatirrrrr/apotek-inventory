@extends('layouts.app')

@section('title', 'Data Obat - Sistem Inventaris Apotek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-capsule me-2"></i>Data Obat
            </h2>
            <a href="{{ route('obat.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Obat
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul me-2"></i>Daftar Obat
                        </h5>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-info">{{ $obats->total() }} Total Obat</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($obats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th width="12%">Harga</th>
                                    <th width="8%">Stok</th>
                                    <th width="12%">Expired</th>
                                    <th width="8%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obats as $index => $obat)
                                    <tr>
                                        <td class="text-muted">{{ $obats->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $obat->nama_obat }}</span>
                                                @if($obat->deskripsi)
                                                    <small class="text-muted">{{ Str::limit($obat->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $obat->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap">
                                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @if($obat->isOutOfStock())
                                                <span class="badge bg-danger">{{ $obat->stok }}</span>
                                            @elseif($obat->isLowStock())
                                                <span class="badge bg-warning text-dark">{{ $obat->stok }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $obat->stok }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="text-muted">
                                                {{ $obat->expired ? $obat->expired->format('d/m/Y') : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($obat->isExpired())
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Expired
                                                </span>
                                            @elseif($obat->isExpiringSoon())
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>Akan Expired
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Baik
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('obat.edit', $obat->id) }}" 
                                                class="btn btn-outline-warning"
                                                title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger"
                                                        onclick="confirmDelete({{ $obat->id }}, '{{ $obat->nama_obat }}')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination & info -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                        <div class="text-muted mb-2 mb-md-0">
                            Menampilkan {{ $obats->firstItem() }} - {{ $obats->lastItem() }} 
                            dari {{ $obats->total() }} data
                        </div>
                        <div>
                            {{ $obats->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">Belum ada data obat</h5>
                        <p class="text-muted">Klik tombol "Tambah Obat" untuk menambahkan data obat pertama</p>
                        <a href="{{ route('obat.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Obat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus obat <strong id="deleteItemName"></strong>?</p>
                <div class="alert alert-permanent" style="background-color: #fff3cd;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = '/obat/' + id;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush