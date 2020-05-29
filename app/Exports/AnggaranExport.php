<?php

namespace App\Exports;

use App\Models\Anggaran;
use App\Models\DinasBop;
use App\Models\DinasRegular;
use App\Models\Kegiatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnggaranExport implements FromView
{
    protected $dari;
    protected $sampai;

    function __construct($dari, $sampai) {
        $this->dari = explode('-',$dari);
        $this->sampai = explode('-',$sampai);
    }

    public function view(): View{
        $sql_kegiatan = Kegiatan::with('pegawai')->get();
        $kegiatan = [];
        $output_table = [];
        $anggaran = [];
        $serapan = [];
        $sql_anggaran = '';
        $i = 0;

        foreach ($sql_kegiatan as $v) {
            $anggaran_int = 0;
            $serapan_int = 0;
            $sisa_int = 0;

            $total_regular = 0;
            array_push($kegiatan, $v->nama_kegiatan);

            $sql_anggaran = Anggaran::where('bulan','>=', $this->dari[1])
                ->where('tahun','>=', $this->dari[0])
                ->where('bulan','<=', $this->sampai[1])
                ->where('tahun','<=', $this->sampai[0])
                ->where('kegiatan_id', $v->id)
                ->sum('jumlah');

            $sql_serapan_bop = DinasBop::whereMonth('created_at','>=', $this->dari[1])
                                        ->whereYear('created_at','>=', $this->dari[0])
                                        ->whereMonth('created_at','<=', $this->sampai[1])
                                        ->whereYear('created_at','<=', $this->sampai[0])
                                        ->where('kegiatan_id', $v->id)->sum('total_anggaran');

            $sql_serapan_regular = DinasRegular::whereMonth('created_at','>=', $this->dari[1])
                                                ->whereYear('created_at','>=', $this->dari[0])
                                                ->whereMonth('created_at','<=', $this->sampai[1])
                                                ->whereYear('created_at','<=', $this->sampai[0])
                                                ->where('kegiatan_id', $v->id)->get();

            if (count($sql_serapan_regular) > 0) {
                foreach ($sql_serapan_regular as $o) {
                    $total_regular = $o->total_harian + $o->total_akomodasi + $o->total_transportasi['total'];
                }
            }

            $anggaran_int = intval($sql_anggaran);
            $serapan_int = intval($total_regular + $sql_serapan_bop);
            $sisa_int = intval($sql_anggaran) - intval($total_regular + $sql_serapan_bop);

            array_push($output_table, ['bendahara' => $v->pegawai->nama, 'kegiatan' => $v->nama_kegiatan,'anggaran' => $anggaran_int, 'serapan' => $serapan_int, 'sisa' => $sisa_int]);
        }

        return view('excel', ['data' => $output_table]);
    }
}
