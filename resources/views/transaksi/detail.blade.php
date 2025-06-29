<div>
    <h5>Kode Transaksi: <span class="badge bg-primary">{{ $transaksi->kode_transaksi }}</span></h5>
    <ul class="list-group mb-2">
        <li class="list-group-item d-flex justify-content-between">
            <span>Tanggal Transaksi</span>
            <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Kasir</span>
            <span>{{ $transaksi->user->name }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Obat</span>
            <span>{{ $transaksi->obat->nama_obat }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Kategori</span>
            <span>{{ $transaksi->obat->kategori->nama_kategori ?? '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Jumlah</span>
            <span>{{ $transaksi->jumlah }} {{ $transaksi->obat->satuan ?? 'pcs' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Harga Satuan</span>
            <span>Rp {{ number_format($transaksi->harga_satuan, 0, ',', '.') }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Total Harga</span>
            <span><b class="text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</b></span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Nama Pembeli</span>
            <span>{{ $transaksi->nama_pembeli ?? '-' }}</span>
        </li>
    </ul>
</div>