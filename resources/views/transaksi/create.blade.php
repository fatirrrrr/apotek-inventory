@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cash-register me-2"></i>Transaksi Penjualan Baru
                    </h5>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
                        @csrf
                        
                        <!-- Informasi Transaksi -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-2"></i>Informasi Transaksi
                                        </h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Kode Transaksi</label>
                                                <input type="text" class="form-control" value="{{ $kodeTransaksi }}" readonly>
                                                <input type="hidden" name="kode_transaksi" value="{{ $kodeTransaksi }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Tanggal</label>
                                                <input type="text" class="form-control" value="{{ date('d/m/Y H:i') }}" readonly>
                                                <input type="hidden" name="tanggal_transaksi" value="{{ now() }}">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label">Kasir</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-calculator me-2"></i>Total Pembayaran
                                        </h6>
                                        <h2 class="mb-0" id="totalBayar">Rp 0</h2>
                                        <small>Total yang harus dibayar</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pilih Obat -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-pills me-2"></i>Pilih Obat
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="obat_id" class="form-label">
                                            Nama Obat <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('obat_id') is-invalid @enderror" 
                                                id="obat_id" 
                                                name="obat_id" 
                                                required>
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($obats as $obat)
                                                <option value="{{ $obat->id }}" 
                                                        data-harga="{{ $obat->harga }}"
                                                        data-stok="{{ $obat->stok }}"
                                                        data-expired="{{ $obat->expired ? $obat->expired->format('d/m/Y') : '' }}"
                                                        {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                                                    {{ $obat->nama_obat }} - {{ $obat->kategori->nama_kategori }} 
                                                    (Stok: {{ $obat->stok }}) 
                                                    - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('obat_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="jumlah" class="form-label">
                                            Jumlah <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('jumlah') is-invalid @enderror" 
                                               id="jumlah" 
                                               name="jumlah" 
                                               value="{{ old('jumlah', 1) }}" 
                                               min="1" 
                                               required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Stok tersedia: <span id="stokTersedia">-</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="harga_satuan_display" 
                                               readonly>
                                        <input type="hidden" name="harga_satuan" id="harga_satuan">
                                    </div>
                                </div>
                                
                                <!-- Info Obat Terpilih -->
                                <div id="infoObat" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong id="namaObatTerpilih">-</strong><br>
                                                <small>Kategori: <span id="kategoriObat">-</span></small><br>
                                                <small>Tanggal Expired: <span id="tanggalExpired">-</span></small>
                                            </div>
                                            <div class="text-end">
                                                <h5>Total: <span id="totalHarga">Rp 0</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-success" id="btnSubmit" disabled>
                                        <i class="fas fa-cash-register me-1"></i>Proses Transaksi
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
    const obatSelect = document.getElementById('obat_id');
    const jumlahInput = document.getElementById('jumlah');
    const hargaSatuanInput = document.getElementById('harga_satuan');
    const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
    const stokTersediaSpan = document.getElementById('stokTersedia');
    const infoObatDiv = document.getElementById('infoObat');
    const namaObatSpan = document.getElementById('namaObatTerpilih');
    const kategoriObatSpan = document.getElementById('kategoriObat');
    const tanggalExpiredSpan = document.getElementById('tanggalExpired');
    const totalHargaSpan = document.getElementById('totalHarga');
    const totalBayarH2 = document.getElementById('totalBayar');
    const btnSubmit = document.getElementById('btnSubmit');

    let hargaSatuan = 0;
    let stokTersedia = 0;

    // Function untuk format rupiah
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Function untuk menghitung total
    function hitungTotal() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        const total = hargaSatuan * jumlah;
        
        totalHargaSpan.textContent = formatRupiah(total);
        totalBayarH2.textContent = formatRupiah(total);
        
        // Validasi stok
        if (jumlah > stokTersedia) {
            jumlahInput.classList.add('is-invalid');
            btnSubmit.disabled = true;
            jumlahInput.nextElementSibling.textContent = 'Jumlah melebihi stok yang tersedia!';
            jumlahInput.nextElementSibling.classList.remove('form-text');
            jumlahInput.nextElementSibling.classList.add('invalid-feedback');
        } else {
            jumlahInput.classList.remove('is-invalid');
            if (obatSelect.value && jumlah > 0) {
                btnSubmit.disabled = false;
            }
            // Reset form text
            const formText = jumlahInput.parentElement.querySelector('.form-text');
            if (formText) {
                formText.innerHTML = 'Stok tersedia: <span id="stokTersedia">' + stokTersedia + '</span>';
            }
        }
    }

    // Event listener untuk perubahan obat
    obatSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            hargaSatuan = parseInt(selectedOption.dataset.harga) || 0;
            stokTersedia = parseInt(selectedOption.dataset.stok) || 0;
            const expired = selectedOption.dataset.expired || '-';
            
            // Update tampilan
            hargaSatuanInput.value = hargaSatuan;
            hargaSatuanDisplay.value = formatRupiah(hargaSatuan);
            stokTersediaSpan.textContent = stokTersedia;
            
            // Update info obat
            const obatText = selectedOption.textContent;
            const parts = obatText.split(' - ');
            namaObatSpan.textContent = parts[0];
            kategoriObatSpan.textContent = parts[1].split(' (')[0];
            tanggalExpiredSpan.textContent = expired;
            
            // Tampilkan info obat
            infoObatDiv.style.display = 'block';
            
            // Hitung total
            hitungTotal();
            
            // Set max untuk input jumlah
            jumlahInput.max = stokTersedia;
            
            // Cek jika stok habis
            if (stokTersedia <= 0) {
                jumlahInput.disabled = true;
                btnSubmit.disabled = true;
                const alertDiv = infoObatDiv.querySelector('.alert');
                alertDiv.classList.remove('alert-info');
                alertDiv.classList.add('alert-danger');
                alertDiv.innerHTML = '<strong>Stok obat ini sudah habis!</strong><br>Silakan pilih obat lain.';
            } else {
                jumlahInput.disabled = false;
                const alertDiv = infoObatDiv.querySelector('.alert');
                alertDiv.classList.remove('alert-danger');
                alertDiv.classList.add('alert-info');
                
                // Cek jika akan expired dalam 30 hari
                if (expired !== '-') {
                    const expiredDate = new Date(expired.split('/').reverse().join('-'));
                    const now = new Date();
                    const diffTime = expiredDate - now;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (diffDays <= 30 && diffDays > 0) {
                        alertDiv.innerHTML += '<br><small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Obat ini akan expired dalam ' + diffDays + ' hari!</small>';
                    } else if (diffDays <= 0) {
                        alertDiv.classList.remove('alert-info');
                        alertDiv.classList.add('alert-danger');
                        alertDiv.innerHTML += '<br><small><i class="fas fa-times-circle"></i> Obat ini sudah expired!</small>';
                        jumlahInput.disabled = true;
                        btnSubmit.disabled = true;
                    }
                }
            }
        } else {
            // Reset semua field
            hargaSatuan = 0;
            stokTersedia = 0;
            hargaSatuanInput.value = '';
            hargaSatuanDisplay.value = '';
            stokTersediaSpan.textContent = '-';
            infoObatDiv.style.display = 'none';
            totalHargaSpan.textContent = 'Rp 0';
            totalBayarH2.textContent = 'Rp 0';
            btnSubmit.disabled = true;
            jumlahInput.disabled = false;
            jumlahInput.max = '';
        }
    });

    // Event listener untuk perubahan jumlah
    jumlahInput.addEventListener('input', function() {
        hitungTotal();
    });

    // Validasi form sebelum submit
    document.getElementById('transaksiForm').addEventListener('submit', function(e) {
        const obatId = obatSelect.value;
        const jumlah = parseInt(jumlahInput.value) || 0;
        
        if (!obatId) {
            e.preventDefault();
            alert('Silakan pilih obat terlebih dahulu!');
            obatSelect.focus();
            return false;
        }
        
        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah harus lebih dari 0!');
            jumlahInput.focus();
            return false;
        }
        
        if (jumlah > stokTersedia) {
            e.preventDefault();
            alert('Jumlah melebihi stok yang tersedia!');
            jumlahInput.focus();
            return false;
        }
        
        // Konfirmasi transaksi
        const total = hargaSatuan * jumlah;
        const obatNama = obatSelect.options[obatSelect.selectedIndex].textContent.split(' - ')[0];
        
        if (!confirm(`Konfirmasi Transaksi:\n\nObat: ${obatNama}\nJumlah: ${jumlah}\nTotal: ${formatRupiah(total)}\n\nProses transaksi ini?`)) {
            e.preventDefault();
            return false;
        }
        
        // Disable tombol submit untuk mencegah double submit
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
    });

    // Auto focus pada select obat
    obatSelect.focus();
});
</script>
@endsection