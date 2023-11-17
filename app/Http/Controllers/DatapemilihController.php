<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatapemilihController extends Controller
{
    public function index()
    {
        // Ambil nilai unik dari kolom 'DESA'
        $data['desaValues'] = Pemilih::distinct('DESA')->pluck('DESA');

        // Buat array untuk menyimpan konfigurasi kolom pivot
        $pivotColumns = [];

        // Loop melalui nilai-nilai DESA dan konfigurasikan kolom pivot
        foreach ($data['desaValues'] as $desa) {
            $columnName = str_replace(' ', '_', $desa);
            $pivotColumns[] = Pemilih::raw("SUM(CASE WHEN DESA = '$desa' THEN 1 ELSE 0 END) AS $columnName");
        }

        // Ambil data pivot menggunakan konfigurasi kolom pivot
        $data['pivotData'] = Pemilih::select('pendamping', ...$pivotColumns)
            ->groupBy('pendamping')
            ->get();


        // dd($pivotData);
        $data['pemilih'] = Pemilih::all();
        return view('pemilih.index', $data);
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new DataImport, $file);

        return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
    }
}
