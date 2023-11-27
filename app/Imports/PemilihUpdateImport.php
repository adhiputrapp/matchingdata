<?php

namespace App\Imports;

use App\Models\Datadpt;
use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemilihUpdateImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public $globalVariable = 0;
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row) {
            if (!isset($row['desakelurahan']) || !isset($row['nama']) || !isset($row['rt']) || !isset($row['rw'])) {
                // Jika satu atau beberapa kolom tidak ada, skip baris ini
                continue;
            }

            if ($row->has('ket')) {
                // Jika indeks '11' ada, periksa apakah nilai tidak null
                if ($row['ket']) {
                    $this->globalVariable++;
                }
            }
            $dpt = new Datadpt();
            $dpt->desa = $row['desakelurahan'];
            $dpt->kpm = $row['nama'];
            $dpt->rt = $row['rt'];
            $dpt->rw = $row['rw'];
            $dpt->tps = $this->globalVariable;
            $dpt->save();
        }
    }
    //  public function headingRow(): int
    // {
    //     return 2;
    // }

}
