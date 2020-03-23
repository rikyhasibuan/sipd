<?php


namespace App\Http\Controllers\Api;

use App\Models\Pemagangan;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function getReport(Request $request) {
        try {
            $_perusahaan = isset($request['perusahaan']) ? $request['perusahaan'] : '';
            $_jenis = isset($request['jenis']) ? $request['jenis'] : '';

            if ($_jenis == 'pemagangan') {
                $pemagangan = Pemagangan::with('perusahaan', 'user')->searchPerusahaan($_perusahaan)->orderBy('id', 'DESC')->get();

                return Excel::create('Laporan Pemagangan', function ($excel) use ($pemagangan) {
                    $excel->sheet('Laporan Pemagangan', function ($sheet) use ($pemagangan) {
                        $sheet->loadView('exports.pemagangan', ['data' => $pemagangan]);
                    });
                })->download('xls');
            } elseif ($_jenis == 'penempatan') {
                $penempatan = Penempatan::with('perusahaan', 'user')->searchPerusahaan($_perusahaan)->orderBy('id', 'DESC')->get();

                return Excel::create('Laporan Penempatan', function ($excel) use ($penempatan) {
                    $excel->sheet('Laporan Penempatan', function ($sheet) use ($penempatan) {
                        $sheet->loadView('exports.penempatan', ['data' => $penempatan]);
                    });
                })->download('xls');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
