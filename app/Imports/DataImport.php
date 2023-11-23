<?php

namespace App\Imports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DataImport implements ToModel, WithChunkReading, WithHeadingRow
{
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
            'no_hp_korkab' => $row['NO_HP_KORKAB'],
            'kecamatan' => $row['KECAMATAN'],
            'korcam' => $row['NAMA_KORCAM'],
            'no_hp_korcam' => $row['NO_HP_KORCAM'],
            'pendamping' => $row['NAMA_PENDAMPING'],
            'no_hp_pendamping' => $row['NO_HP_PENDAMPING'],
            'desa' => $row['DESA'],
            'kpm' => $row['NAMA_KPM'],
            'no_hp_kpm' => $row['NO_HP_KKPM'],
            'rt' => $row['RT'],
            'rw' => $row['RW'],
            'tps' => $row['TPS'],
        ]);
    }

    public function chunkSize(): int
    {
        return 250; // Jumlah baris per chunk
    }
}