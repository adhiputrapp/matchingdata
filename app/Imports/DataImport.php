<?php

namespace App\Imports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pemilih([
            'korkab' => $row['NAMA KORKAB'],
            'no_hp_korkab' => $row['NO HP KORKAB'],
            'kecamatan' => $row['KECAMATAN'],
            'korcam' => $row['NAMA KORCAM'],
            'no_hp_korcam' => $row['NO HP KORCAM'],
            'pendamping' => $row['NAMA PENDAMPING'],
            'no_hp_pendamping' => $row['NO HP PENDAMPING'],
            'desa' => $row['DESA'],
            'kpm' => $row['NAMA KKPM'],
            'no_hp_kpm' => $row['NO HP KKPM'],
            'rt' => $row['RT'],
            'rw' => $row['RW'],
            'tps' => $row['TPS'],
        ]);
    }
}