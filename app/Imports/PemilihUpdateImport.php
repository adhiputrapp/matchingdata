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
            if ($row->has('11')) {
                // Jika indeks '11' ada, periksa apakah nilai tidak null
                if (!is_null($row[11])) {
                    $this->globalVariable++;
                }
            }
            $dpt = new Datadpt();
            $dpt->desa = $row['jalandukuh'];
            $dpt->kpm = $row[1];
            $dpt->rt = $row['rt'];
            $dpt->rw = $row['rw'];
            $dpt->tps = $this->globalVariable;
            $dpt->save();
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
