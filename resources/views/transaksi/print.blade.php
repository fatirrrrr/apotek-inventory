<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Struk Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; padding: 0; }
        .struk-container { max-width: 350px; margin: 20px auto; border: 1px solid #e0e0e0; padding: 16px; background: #fff; border-radius: 8px; }
        .brand { text-align: center; }
        .brand h2 { margin: 0; }
        .brand small { color: #666; }
        .line { border-top: 1px dashed #bbb; margin: 12px 0; }
        .info, .total, .footer { margin-bottom: 12px; }
        .info table, .items, .total table { width: 100%; }
        .items th, .items td { text-align: left; padding: 4px 0; }
        .items th { border-bottom: 1px solid #ddd; }
        .total td { padding: 4px 0; }
        .footer { text-align: center; color: #888; font-size: 12px; }
        @media print {
            body { background: none; }
            .struk-container { box-shadow: none; border: none; }
            .footer { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="struk-container">
        <div class="brand">
            <h2>Apotek System</h2>
            <small>Jl. Contoh No. 123, Kota Anda</small>
        </div>
        <div class="line"></div>
        <div class="info">
            <table>
                <tr>
                    <td><strong>Kode</strong></td>
                    <td>:</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Kasir</strong></td>
                    <td>:</td>
                    <td>{{ $transaksi->user->name }}</td>
                </tr>
            </table>
        </div>
        <div class="line"></div>
        <table class="items">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jml</th>
                    <th>Harga</th>
                    <th>Subtot.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $transaksi->obat->nama_obat }}</td>
                    <td>{{ $transaksi->jumlah }} {{ $transaksi->obat->satuan ?? 'pcs' }}</td>
                    <td>Rp {{ number_format($transaksi->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="line"></div>
        <div class="total">
            <table>
                <tr>
                    <td><strong>Total</strong></td>
                    <td style="text-align:right;"><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="line"></div>
        <div class="footer">
            <div>Terima kasih atas kunjungan Anda!</div>
            <div>-- Apotek System --</div>
        </div>
    </div>
</body>
</html>