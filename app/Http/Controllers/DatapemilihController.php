<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DatapemilihController extends Controller
{
    public function index()
    {
        $data['results'] = DB::table('pemilih')
            ->select('korkab')
            ->selectRaw("
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'Kecamatan', kecamatan,
                        'korcam', korcam,
                        'pendamping', pendamping,
                        'desa_kpm', desa_kpm
                    )
                ) AS result
            ")
            ->from(DB::raw("
                (SELECT 
                    korkab,
                    kecamatan, 
                    korcam, 
                    pendamping,
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'rt', rt,
                            'rw', rw,
                            'kpm', kpm_array,
                            'tps', tps,
                            'desa', desa
                        )
                    ) AS desa_kpm
                FROM (
                    SELECT 
                        korkab,
                        kecamatan, 
                        korcam,
                        pendamping,
                        desa,
                        MAX(rt) AS rt,  
                        MAX(rw) AS rw,
                        JSON_ARRAYAGG(kpm) AS kpm_array,
                        MAX(tps) AS tps
                    FROM 
                        pemilih 
                    GROUP BY 
                        korkab, kecamatan, korcam, pendamping, desa
                ) AS desa_kpm_subquery
                GROUP BY 
                    korkab, kecamatan, korcam, pendamping
            ) AS korcam_subquery"))
            ->groupBy('korkab')
            ->orderBy('korkab')
            ->get();





        // dd($pivotData);
        $data['pemilih'] = Pemilih::all();
        return view('pemilih.index', $data);
    }

    public function ajax_finder(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new DataImport, $file);

        return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
    }
    public function import(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new DataImport, $file);

        return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
    }
}
