@extends('layouts.app')

@section('title', 'Tambah Obat - Sistem Inventaris Apotek')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-plus-circle me-2"></i>Tambah Obat Baru
            </h2>
            <a href="{{ route('obat.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-form me-2"></i>Form Tambah Obat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('obat.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Nama Obat -->
                        <div class="col-md-12 mb-3">
                            <label for="nama_obat" class="form-label">
                                Nama Obat <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_obat') is-invalid @enderror" 
                                   id="nama_obat" 
                                   name="nama_obat" 
                                   value="{{ old('nama_obat') }}"
                                   placeholder="Masukkan nama obat"
                                   required>
                            @error('nama_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" 
                                    name="kategori_id" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($kategoris->count() == 0)
                                <div class="form-text text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Belum ada kategori. <a href="{{ route('kategori.create') }}">Tambah kategori dulu</a>
                                </div>
                            @endif
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="harga" class="form-label">
                                Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" 
                                       name="harga" 
                                       value="{{ old('harga') }}"
                                       placeholder="0"
                                       min="0"
                                       step="0.01"
                                       required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label">
                                Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stok') is-invalid @enderror" 
                                   id="stok" 
                                   name="stok" 
                                   value="{{ old('stok') }}"
                                   placeholder="0"
                                   min="0"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Expired -->
                        <div class="col-md-6 mb-3">
                            <label for="expired" class="form-label">
                                Tanggal Expired <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('expired') is-invalid @enderror" 
                                   id="expired" 
                                   name="expired" 
                                   value="{{ old('expired') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required>
                            @error('expired')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Tanggal expired harus setelah hari ini
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"
                                      placeholder="Masukkan deskripsi obat (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alert Info -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Catatan:</strong> 
                        Pastikan semua data yang dimasukkan sudah benar. 
                        Field yang bertanda <span class="text-danger">*</span> wajib diisi.
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto format currency on input
    const hargaInput = document.getElementById('harga');
    
    hargaInput.addEventListener('input', function(e) {
        // Remove non-numeric characters except decimal point
        let value = e.target.value.replace(/[^\d.]/g, '');
        
        // Ensure only one decimal point
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        e.target.value = value;
    });

    // Set minimum date for expired date
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const minDate = tomorrow.toISOString().split('T')[0];
    document.getElementById('expired').setAttribute('min', minDate);
});
</script>
@endpush