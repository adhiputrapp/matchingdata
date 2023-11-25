<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\dptsecond;
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

    public function kecamatan($kecamatan)
    {
        // dd($pivotData);
        $data['kecamatan'] = $kecamatan;
        $data['pemilih'] = Pemilih::join('dpt', function($join) {
            $join->on('dpt.desa', '=', 'pemilih.desa')
                ->on('dpt.kpm', '=', 'pemilih.kpm')
                ->on('dpt.rt', '=', 'pemilih.rt')
                ->on('dpt.rw', '=', 'pemilih.rw')
                ->on('dpt.tps', '=', 'pemilih.tps');
        })
        ->select('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
            ->selectRaw('JSON_ARRAYAGG(pemilih.kpm) AS kpm_array')
            ->where('pemilih.kecamatan', $kecamatan)
            ->groupBy('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
            ->get();

        $data['tidaksama'] = Pemilih::leftJoin('dpt', function($join) {
            $join->on('dpt.desa', '=', 'pemilih.desa')
                ->on('dpt.kpm', '=', 'pemilih.kpm')
                ->on('dpt.rt', '=', 'pemilih.rt')
                ->on('dpt.rw', '=', 'pemilih.rw')
                ->on('dpt.tps', '=', 'pemilih.tps');
        })
        ->select('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
        ->selectRaw('JSON_ARRAYAGG(pemilih.kpm) AS kpm_array')
        ->whereNull('dpt.desa')
        ->where('pemilih.kecamatan', $kecamatan)
        ->groupBy('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
        ->get();
        // dd($data['tidaksama']);
        return view('matching.kecamatan', $data);
    }

    public function import(Request $request,$id)
    {
        ini_set('max_execution_time', 300);
        $file = $request->file('file');

        try {
            if($id==1){
            // Import data dari semua sheet, termasuk yang dinamis
            Excel::import(new PemilihUpdateImport, $file);
            }else if($id==2){
                Excel::import(new dptsecond, $file);
            }
            // Excel::import(new PemilihUpdateImport, $file);

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tambahkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
