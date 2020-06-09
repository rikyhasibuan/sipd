<?php

namespace App\Http\Controllers\Api;

use App\Models\Anggaran;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasRegular;
use App\Models\Kegiatan;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Common;

class DashboardController extends Controller
{
    public function getData(Request $request)
    {
        try {
            $common = new Common();
            $kas = new KasAnggaran();
            $tahun = ($request['tahun'] != '') ? $request['tahun'] : date('Y');
            $bulan = ($request['bulan'] != '') ? $request['bulan'] : '12';

            if ($request['bulan'] != '') {
                $message = ' ' .$common->generate_indonesia_month($bulan).' ';
            } else {
                $message = '';
            }

            $sql_kegiatan = Kegiatan::all();
            $kegiatan = [];
            $output_table = [];
            $anggaran = [];
            $serapan = [];
            $sql_anggaran = '';
            $i = 0;
            $anggaran['anggaran'][$i]['name'] ='Total Pagu Anggaran Kegiatan Tahun '.$tahun.'';
            $serapan['serapan'][$i]['name'] ='Total Realisasi Anggaran Kegiatan '.$message.'Tahun '.$tahun.'';

            foreach ($sql_kegiatan as $v) {
                $anggaran_int = 0;
                $serapan_int = 0;
                $sisa_int = 0;

                $total_regular = 0;
                $sql_anggaran = Anggaran::searchTahun($tahun)->searchKegiatan($v->id)->sum('jumlah');
                $sql_serapan_bop = DinasBop::searchTahun($tahun)->searchToBulan($bulan)->searchKegiatan($v->id)->sum('total_anggaran');
                $sql_serapan_regular = DinasRegular::searchTahun($tahun)->searchToBulan($bulan)->searchKegiatan($v->id)->get();

                if (count($sql_serapan_regular) > 0) {
                    foreach ($sql_serapan_regular as $o) {
                        $total_regular += $o->total_harian + $o->total_akomodasi + $o->total_transportasi['total'];
                    }
                }

                $anggaran['anggaran'][$i]['data'][] = intval($sql_anggaran);
                $serapan['serapan'][$i]['data'][] = intval($total_regular + $sql_serapan_bop);

                $anggaran_int = intval($sql_anggaran);
                $serapan_int = intval($total_regular + $sql_serapan_bop);
                $sisa_int = intval($sql_anggaran) - intval($total_regular + $sql_serapan_bop);

                array_push($kegiatan, $v->nama_kegiatan);
                array_push($output_table, ['kegiatan' => $v->nama_kegiatan,'anggaran' => $anggaran_int, 'serapan' => $serapan_int, 'sisa' => $sisa_int]);
            }

            return response()->json(['anggaran' => $anggaran, 'serapan' => $serapan, 'kegiatan' => $kegiatan, 'output_table' => $output_table], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
