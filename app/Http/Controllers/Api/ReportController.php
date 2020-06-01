<?php


namespace App\Http\Controllers\Api;

use App\Exports\AnggaranExport;
use App\Models\Anggaran;
use App\Models\Kegiatan;
use App\Models\Belanja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function print_data(Request $request) {
        try {
            $_dari = isset($request['dari']) ? $request['dari'] : '';
            $_sampai = isset($request['sampai']) ? $request['sampai'] : '';
            $_bendahara = isset($request['bendahara']) ? $request['bendahara'] : '';

            return Excel::download(new AnggaranExport($_dari, $_sampai, $_bendahara), 'Laporan Penyerapan Anggaran Perjalanan Dinas.xlsx');
        } catch (Exception $e) {

        }
    }
}
