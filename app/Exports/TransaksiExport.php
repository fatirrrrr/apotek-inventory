<?php
// app/Exports/TransaksiExport.php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Transaksi::with(['obat', 'user']);

        // Apply filters
        if ($this->request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $this->request->tanggal_dari);
        }

        if ($this->request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $this->request->tanggal_sampai);
        }

        if ($this->request->filled('nama_pembeli')) {
            $query->where('nama_pembeli', 'like', '%' . $this->request->nama_pembeli . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Obat',
            'Jumlah',
            'Harga Satuan',
            'Total Harga',
            'Nama Pembeli',
            'Petugas'
        ];
    }

    /**
     * @param mixed $transaksi
     * @return array
     */
    public function map($transaksi): array
    {
        static $no = 1;

        return [
            $no++,
            $transaksi->created_at->format('d/m/Y H:i'),
            $transaksi->obat->nama,
            $transaksi->jumlah,
            'Rp ' . number_format($transaksi->harga_satuan, 0, ',', '.'),
            'Rp ' . number_format($transaksi->total_harga, 0, ',', '.'),
            $transaksi->nama_pembeli,
            $transaksi->user->name
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
