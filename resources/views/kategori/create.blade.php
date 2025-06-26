@extends('layouts.app')

@section('title', 'Tambah Kategori - Sistem Inventaris Apotek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru
            </h2>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-form me-2"></i>Form Tambah Kategori
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Kategori -->
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               value="{{ old('nama_kategori') }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Contoh: Analgesik, Antibiotik, Vitamin, dll.
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Jelaskan jenis obat yang termasuk dalam kategori ini
                        </div>
                    </div>

                    <!-- Alert Info -->
                    <div class="alert alert-info">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Tips:</strong> 
                        Buat kategori yang mudah dipahami dan spesifik. Ini akan memudahkan 
                        pengelompokan obat dan pencarian data di kemudian hari.
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Examples Card -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Contoh Kategori Obat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-primary me-2">Analgesik</span>
                                <small class="text-muted">Obat pereda nyeri</small>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-success me-2">Antibiotik</span>
                                <small class="text-muted">Obat anti bakteri</small>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-info me-2">Vitamin</span>
                                <small class="text-muted">Suplemen vitamin</small>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-warning me-2">Antasida</span>
                                <small class="text-muted">Obat maag</small>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-danger me-2">Antihistamin</span>
                                <small class="text-muted">Obat alergi</small>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-secondary me-2">Antiseptik</span>
                                <small class="text-muted">Pembersih luka</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto capitalize first letter
    const namaKategoriInput = document.getElementById('nama_kategori');
    
    namaKategoriInput.addEventListener('input', function(e) {
        // Capitalize first letter of each word
        let value = e.target.value;
        value = value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
        e.target.value = value;
    });
});
</script>
@endpush