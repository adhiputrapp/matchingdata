<?php

namespace App\Imports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DataImport implements ToModel, WithChunkReading, WithHeadingRow
{
    protected $sumber;
    public function __construct($sumber)
    {
        $this->sumber = $sumber;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (empty(array_filter($row))) {
            return null; // Mengabaikan baris yang kosong
        }

        $row = array_change_key_case($row, CASE_UPPER);
        // dd($row);
        return new Pemilih([
            'korkab' => $row['NAMA_KORKAB'],
            'kecamatan' => $row['KECAMATAN'],
            'korcam' => $row['NAMA_KORCAM'],
            'pendamping' => $row['NAMA_PENDAMPING'],
            'desa' => $row['DESA'],
            'kpm' => preg_replace('/\s+/', ' ', trim($row['NAMA_KPM'])),
            'rt' => $row['RT'],
            'rw' => $row['RW'],
            'tps' => $row['TPS'],
            'sumber' => $this->sumber,
        ]);
    }

    public function chunkSize(): int
    {
        return 250; // Jumlah baris per chunk
    }
}
