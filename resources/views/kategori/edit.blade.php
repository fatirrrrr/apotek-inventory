@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Kategori
                    </h5>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">
                                        Nama Kategori <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nama_kategori') is-invalid @enderror" 
                                           id="nama_kategori" 
                                           name="nama_kategori" 
                                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                           placeholder="Masukkan nama kategori"
                                           required>
                                    @error('nama_kategori')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="3" 
                                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Kategori
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus pada input pertama
    document.getElementById('nama_kategori').focus();
    
    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKategori = document.getElementById('nama_kategori').value.trim();
        
        if (namaKategori === '') {
            e.preventDefault();
            alert('Nama kategori harus diisi!');
            document.getElementById('nama_kategori').focus();
            return false;
        }
        
        // Konfirmasi sebelum update
        if (!confirm('Apakah Anda yakin ingin mengupdate data kategori ini?')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection