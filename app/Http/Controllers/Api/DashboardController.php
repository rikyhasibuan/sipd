<?php

namespace App\Http\Controllers\Api;

use App\Models\Anggaran;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasRegular;
use App\Models\Kegiatan;
use Exception;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getData()
    {
        try {
            $kas = new KasAnggaran();
            $year = date('Y');
            $sql_kegiatan = Kegiatan::all();
            $kegiatan = [];
            $output_table = [];
            $anggaran = [];
            $serapan = [];
            $sql_anggaran = '';
            $i = 0;
            $anggaran['anggaran'][$i]['name'] ='Total Anggaran Kegiatan';
            $serapan['serapan'][$i]['name'] ='Total Serapan Anggaran Kegiatan';

            foreach ($sql_kegiatan as $v) {
                $anggaran_int = 0;
                $serapan_int = 0;
                $sisa_int = 0;

                $total_regular = 0;
                array_push($kegiatan, $v->nama_kegiatan);
                $sql_anggaran = Anggaran::where('tahun', $year)->where('kegiatan_id', $v->id)->sum('jumlah');

                $sql_serapan_bop = DinasBop::whereYear('created_at', $year)->where('kegiatan_id', $v->id)->sum('total_anggaran');
                $sql_serapan_regular = DinasRegular::whereYear('created_at', $year)->where('kegiatan_id', $v->id)->get();

                if (count($sql_serapan_regular) > 0) {
                    foreach ($sql_serapan_regular as $o) {
                        $total_regular = $o->total_harian + $o->total_akomodasi + $o->total_transportasi['total'];
                    }
                }

                $anggaran['anggaran'][$i]['data'][] = intval($sql_anggaran);
                $serapan['serapan'][$i]['data'][] = intval($total_regular + $sql_serapan_bop);

                $anggaran_int = intval($sql_anggaran);
                $serapan_int = intval($total_regular + $sql_serapan_bop);
                $sisa_int = intval($sql_anggaran) - intval($total_regular + $sql_serapan_bop);
                array_push($output_table, ['kegiatan' => $v->nama_kegiatan,'anggaran' => $anggaran_int, 'serapan' => $serapan_int, 'sisa' => $sisa_int]);
            }

            return response()->json(['anggaran' => $anggaran, 'serapan' => $serapan, 'kegiatan' => $kegiatan, 'output_table' => $output_table], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
