<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pemilih extends Model
{
    use HasFactory;
    protected $table = 'pemilih';

    protected $fillable = [
        'korkab',
        'kecamatan',
        'korcam',
        'pendamping',
        'desa',
        'kpm',
        'rt',
        'rw',
        'tps',
        'sumber',
    ];

    // public static function getPivotData()
    // {
    //     // Ambil nilai unik dari kolom 'DESA'
    //     $desaValues = self::distinct('DESA')->pluck('DESA');

    //     // Buat array untuk menyimpan konfigurasi kolom pivot
    //     $pivotColumns = [];

    //     // Loop melalui nilai-nilai DESA dan konfigurasikan kolom pivot
    //     foreach ($desaValues as $desa) {
    //         $columnName = str_replace(' ', '_', $desa);
    //         $pivotColumns[] = DB::raw("SUM(CASE WHEN DESA = '$desa' THEN 1 ELSE 0 END) AS $columnName");
    //     }

    //     // Ambil data pivot menggunakan konfigurasi kolom pivot
    //     $result = self::select('pendamping', ...$pivotColumns)
    //         ->groupBy('pendamping')
    //         ->get();

    //     return $result;
    // }
}