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
        $data['pemilih'] = Pemilih::groupBy('sumber')->get();

        return view('pemilih.filter', $data);
    }

    public function sumber($sumber)
    {
        // dd($pivotData);
        $data['sumber'] = $sumber;
        $data['pemilih'] = Pemilih::where('sumber', $sumber)
            ->groupby('sumber')
            ->groupby('korkab')
            ->get();

        // dd($data['pemilih']);
        return view('pemilih.sumber', $data);
    }
    public function korkab($sumber, $korkab)
    {
        // dd($pivotData);
        $data['korkab'] = $korkab;
        $data['pemilih'] = Pemilih::select('korkab', 'sumber')
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
                $query->select('korkab', 'kecamatan', 'korcam', 'pendamping', 'sumber')
                    ->selectRaw("
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'kpm', kpm_array,
                        'desa', desa
                    )
                ) AS desa_kpm
            ")
                    ->fromSub(function ($subquery) {
                        $subquery->select('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'sumber')
                            ->selectRaw('JSON_ARRAYAGG(kpm) AS kpm_array')
                            ->from('pemilih')
                            ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa');
                    }, 'desa_kpm_subquery')
                    ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping');
            }, 'korcam_subquery')
            ->where('sumber', $sumber)
            ->where('korkab', $korkab)
            ->groupBy('korkab')
            ->orderBy('korkab')
            ->get();
        // dd($data['pemilih']);
        return view('pemilih.korkab', $data);
    }
    public function kecamatan($sumber, $kecamatan)
    {
        // dd($pivotData);
        $data['kecamatan'] = $kecamatan;
        $data['pemilih'] = Pemilih::select('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'tps', 'sumber')
            ->selectRaw('JSON_ARRAYAGG(kpm) AS kpm_array')
            ->where('sumber', $sumber)
            ->where('kecamatan', $kecamatan)
            ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'tps')
            ->orderBy('korkab','asc')
            ->orderBy('kecamatan','asc')
            ->orderBy('korcam','asc')
            ->orderBy('pendamping','asc')
            ->orderBy('desa','asc')
            ->orderBy('tps','asc')
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
        $sumber = $request->sumber;
        try {
            Excel::import(new DataImport($sumber), $file);

            // Excel::import(new PemilihUpdateImport, $file);

            return redirect()->route('pemilih')->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tambahkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
