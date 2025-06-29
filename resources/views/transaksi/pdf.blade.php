<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 4px 8px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transaksi as $trx)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->obat->nama_obat ?? '-' }}</td>
                <td>{{ $trx->jumlah }}</td>
                <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html> 