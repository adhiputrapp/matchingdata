<?php

namespace App\Imports;

use App\Models\Pemilih;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemilihUpdateImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            Pemilih::where('kpm', $row['1'])->where('desa', $row['5'])
                ->where('desa', $row['5'])
                ->where('rt', $row['6'])
                ->where('rw', $row['7'])
                ->update(['tps' => $row['8']]);
        }
    }

    public function headingRow(): int
    {
        return 3;
    }
}
