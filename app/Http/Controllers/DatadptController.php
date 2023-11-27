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
        return view('matching.index');
    }

    public function filter()
    {
        // dd($pivotData);
        $data['pemilih'] = Pemilih::groupBy('sumber')->get();

        return view('matching.filter', $data);
    }
    public function sumber($sumber)
    {
        // dd($pivotData);
        $data['pemilih'] = Pemilih::groupBy('kecamatan')->get();

        return view('matching.sumber', $data);
    }

    public function kecamatan($sumber, $kecamatan)
    {
        // dd($pivotData);
        $data['kecamatan'] = $kecamatan;
        $data['pemilih'] = Pemilih::selectRaw('korkab, kecamatan, korcam, pendamping, desa, CAST(tps AS DECIMAL) AS tps, sumber')
            ->selectRaw('JSON_ARRAYAGG(kpm) AS kpm_array')
            ->where('sumber', $sumber)
            ->where('kecamatan', $kecamatan)
            ->groupBy('korkab', 'kecamatan', 'korcam', 'pendamping', 'desa', 'tps', 'sumber')
            ->orderBy('korkab', 'asc')
            ->orderBy('kecamatan', 'asc')
            ->orderBy('korcam', 'asc')
            ->orderBy('pendamping', 'asc')
            ->orderBy('desa', 'asc')
            ->orderBy('tps', 'asc')
            ->orderBy('kpm', 'asc')
            ->get();

        $data['sama'] = Pemilih::join('dpt', function ($join) {
            $join->on('dpt.desa', '=', 'pemilih.desa')
                ->on('dpt.kpm', '=', 'pemilih.kpm')
                ->on('dpt.rt', '=', 'pemilih.rt')
                ->on('dpt.rw', '=', 'pemilih.rw')
                ->on('dpt.tps', '=', 'pemilih.tps');
        })
            ->select('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps', 'pemilih.sumber')
            ->selectRaw('JSON_ARRAYAGG(pemilih.kpm) AS kpm_array')
            ->where('pemilih.sumber', $sumber)
            ->where('pemilih.kecamatan', $kecamatan)
            ->groupBy('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
            ->get();

        $data['tidaksama'] = Pemilih::leftJoin('dpt', function ($join) {
            $join->on('dpt.desa', '=', 'pemilih.desa')
                ->on('dpt.kpm', '=', 'pemilih.kpm')
                ->on('dpt.rt', '=', 'pemilih.rt')
                ->on('dpt.rw', '=', 'pemilih.rw')
                ->on('dpt.tps', '=', 'pemilih.tps');
        })
            ->select('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps', 'pemilih.sumber')
            ->selectRaw('JSON_ARRAYAGG(pemilih.kpm) AS kpm_array')
            ->whereNull('dpt.desa')
            ->where('pemilih.sumber', $sumber)
            ->where('pemilih.kecamatan', $kecamatan)
            ->groupBy('pemilih.korkab', 'pemilih.kecamatan', 'pemilih.korcam', 'pemilih.pendamping', 'pemilih.desa', 'pemilih.tps')
            ->get();
        // dd($data['tidaksama']);
        return view('matching.kecamatan', $data);
    }

    public function import(Request $request, $id)
    {
        ini_set('max_execution_time', 300);
        $file = $request->file('file');

        try {
            if ($id == 1) {
                // Import data dari semua sheet, termasuk yang dinamis
                Excel::import(new PemilihUpdateImport, $file);
            } else if ($id == 2) {
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