<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                'Tanggal'    => $item['tanggal'],
                'Jenis'      => $item['jenis'],
                'Nama'       => $item['nama'],
                'Keterangan' => $item['keterangan'],
                'Jumlah'     => $item['jumlah'],
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jenis', 'Nama', 'Keterangan', 'Jumlah'];
    }
}
