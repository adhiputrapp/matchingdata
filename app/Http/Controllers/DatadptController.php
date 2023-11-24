<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\PemilihUpdateImport;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatadptController extends Controller
{
    public function index()
    {
        // $data['results'] = DB::table('pemilih')
        //     ->select('korkab')
        //     ->selectRaw("
        //         JSON_ARRAYAGG(
        //             JSON_OBJECT(
        //                 'Kecamatan', kecamatan,
        //                 'korcam', korcam,
        //                 'pendamping', pendamping,
        //                 'desa_kpm', desa_kpm
        //             )
        //         ) AS result
        //     ")
        //     ->from(DB::raw("
        //         (SELECT 
        //             korkab,
        //             kecamatan, 
        //             korcam, 
        //             pendamping,
        //             JSON_ARRAYAGG(
        //                 JSON_OBJECT(
        //                     'rt', rt,
        //                     'rw', rw,
        //                     'kpm', kpm_array,
        //                     'tps', tps,
        //                     'desa', desa
        //                 )
        //             ) AS desa_kpm
        //         FROM (
        //             SELECT 
        //                 korkab,
        //                 kecamatan, 
        //                 korcam,
        //                 pendamping,
        //                 desa,
        //                 MAX(rt) AS rt,  
        //                 MAX(rw) AS rw,
        //                 JSON_ARRAYAGG(kpm) AS kpm_array,
        //                 MAX(tps) AS tps
        //             FROM 
        //                 pemilih 
        //             GROUP BY 
        //                 korkab, kecamatan, korcam, pendamping, desa
        //         ) AS desa_kpm_subquery
        //         GROUP BY 
        //             korkab, kecamatan, korcam, pendamping
        //     ) AS korcam_subquery"))
        //     ->groupBy('korkab')
        //     ->orderBy('korkab')
        //     ->get();





        // dd($pivotData);
        // $data['pemilih'] = Pemilih::all();
        return view('matching.index');
    }

    public function filter()
    {
        // dd($pivotData);
        $data['pemilih'] = Pemilih::groupBy('kecamatan')->get();

        return view('matching.filter', $data);
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 300);
        $file = $request->file('file');

        try {
            // Import data dari semua sheet, termasuk yang dinamis
            Excel::import(new PemilihUpdateImport, $file);

            // Excel::import(new PemilihUpdateImport, $file);

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tambahkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
