<?php

namespace App\Imports;

use App\Models\Pemilih;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PemilihUpdateImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pemilih::table('pemilih')->insert([
                'korkab' => $row['korkab'],
                'kecamatan' => $row['kecamatan'],
                'korcam' => $row['korcam'],
                'pendamping' => $row['pendamping'],
                'desa' => $row['desa'],
                'kpm' => $row['kpm'],
                'rt' => $row['rt'],
                'rw' => $row['rw'],
                'tps' => $row['tps'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
