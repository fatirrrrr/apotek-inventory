@extends('layouts.app')

@section('title', 'Data Kategori - Sistem Inventaris Apotek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-tags me-2"></i>Data Kategori
            </h2>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
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
                            <i class="bi bi-list-ul me-2"></i>Daftar Kategori
                        </h5>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-info">{{ $kategoris->total() }} Total Kategori</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kategoris->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th width="12%">Jumlah Obat</th>
                                    <th width="15%">Dibuat</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoris as $index => $kategori)
                                    <tr>
                                        <td class="text-muted">{{ $kategoris->firstItem() + $index }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $kategori->nama_kategori }}</span>
                                        </td>
                                        <td>
                                            @if($kategori->deskripsi)
                                                <span class="text-muted">{{ Str::limit($kategori->deskripsi, 80) }}</span>
                                            @else
                                                <span class="text-muted fst-italic">Tidak ada deskripsi</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($kategori->obats_count > 0)
                                                <span class="badge bg-success fs-6">{{ $kategori->obats_count }} obat</span>
                                            @else
                                                <span class="badge bg-secondary fs-6">0 obat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $kategori->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('kategori.edit', $kategori->id) }}" 
                                                   class="btn btn-outline-warning"
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger"
                                                        onclick="confirmDelete({{ $kategori->id }}, '{{ $kategori->nama_kategori }}', {{ $kategori->obats_count }})"
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $kategoris->firstItem() }} - {{ $kategoris->lastItem() }} 
                            dari {{ $kategoris->total() }} data
                        </div>
                        <div>
                            {{ $kategoris->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">Belum ada data kategori</h5>
                        <p class="text-muted">Klik tombol "Tambah Kategori" untuk menambahkan kategori pertama</p>
                        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Pertama
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
                <p>Apakah Anda yakin ingin menghapus kategori <strong id="deleteItemName"></strong>?</p>
                <div id="deleteWarning" class="alert alert-danger" style="display: none;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> Kategori ini memiliki <span id="obatCount"></span> obat. 
                    Hapus semua obat dalam kategori ini terlebih dahulu sebelum menghapus kategori.
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteButton">
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
function confirmDelete(id, name, obatCount) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = '/kategori/' + id;
    
    const warningDiv = document.getElementById('deleteWarning');
    const deleteButton = document.getElementById('deleteButton');
    
    if (obatCount > 0) {
        warningDiv.style.display = 'block';
        document.getElementById('obatCount').textContent = obatCount;
        deleteButton.disabled = true;
        deleteButton.innerHTML = '<i class="bi bi-x-circle me-2"></i>Tidak Dapat Dihapus';
    } else {
        warningDiv.style.display = 'none';
        deleteButton.disabled = false;
        deleteButton.innerHTML = '<i class="bi bi-trash3 me-2"></i>Ya, Hapus';
    }
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush