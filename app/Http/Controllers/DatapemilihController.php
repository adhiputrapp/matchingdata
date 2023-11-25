<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\PemilihUpdateImport;
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


    public function filter()
    {
        // dd($pivotData);
        $data['pemilih'] = Pemilih::groupBy('korkab')->get();

        return view('pemilih.filter', $data);
    }
    public function korkab($korkab)
    {
        // dd($pivotData);
        $data['korkab'] = $korkab;
        $data['pemilih'] =
            Pemilih::select('korkab')
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
                ->fromSub(function ($query) {
                    $query->select('korkab', 'kecamatan', 'korcam', 'pendamping')
                        ->selectRaw("
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'kpm', kpm_array,
                        'desa', desa
                    )
                ) AS desa_kpm
            ")
                        ->fromSub(function ($subquery) {
                            $subquery->select('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa')
                                ->selectRaw('JSON_ARRAYAGG(kpm) AS kpm_array')
                                ->from('pemilih')
                                ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa');
                        }, 'desa_kpm_subquery')
                        ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping');
                }, 'korcam_subquery')
                ->where('korkab', $korkab)
                ->groupBy('korkab')
                ->orderBy('korkab')
                ->get();
        // dd($data['pemilih']);
        return view('pemilih.korkab', $data);
    }
    public function kecamatan($kecamatan)
    {
        // dd($pivotData);
        $data['kecamatan'] = $kecamatan;
        $data['pemilih'] = Pemilih::select('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'tps')
            ->selectRaw('JSON_ARRAYAGG(kpm) AS kpm_array')
            ->where('kecamatan', $kecamatan)
            ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'tps')
            ->get();
        // dd($data['pemilih']);
        return view('pemilih.kecamatan', $data);
    }

    public function ajax_finder(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new DataImport, $file);

        return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
    }
    public function import(Request $request)
    {
        ini_set('max_execution_time', 300);
        $file = $request->file('file');
        try {
            Excel::import(new DataImport, $file);

            // Excel::import(new PemilihUpdateImport, $file);

            return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tambahkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
