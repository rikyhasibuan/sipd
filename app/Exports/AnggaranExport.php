<?php

namespace App\Exports;

use App\Models\Anggaran;
use App\Models\Belanja;
use App\Models\DinasBop;
use App\Models\DinasRegular;
use App\Models\Kegiatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnggaranExport implements FromView, ShouldAutoSize
{
    protected $dari;
    protected $sampai;
    protected $bendahara;

    function __construct($dari, $sampai, $bendahara) {
        $this->dari = explode('-',$dari);
        $this->sampai = explode('-',$sampai);
        $this->bendahara = $bendahara;
    }

    public function view(): View{
        $sql_kegiatan = Kegiatan::searchBendahara($this->bendahara)->with('pegawai')->get();
        $output = [];
        $i = 0;
        $dari = $this->dari;
        $sampai = $this->sampai;
        if (count($sql_kegiatan) > 0) {
            foreach ($sql_kegiatan as $v) {
                $total_regular = 0;
                $belanja = Belanja::where('kegiatan_id', $v->id)->get();
                foreach ($belanja as $obj) {
                    $sql_anggaran = Anggaran::where(function ($query) use ($dari, $sampai) {
                        $query->whereBetween('tahun', [$dari[0], $sampai[0]]);
                    })->where(['kegiatan_id' => $v->id, 'belanja_id' => $obj->id])->sum('jumlah');

                    $sql_serapan_bop = DinasBop::whereMonth('created_at','>=', $dari[1])
                        ->whereYear('created_at','>=', $dari[0])
                        ->whereMonth('created_at','<=', $sampai[1])
                        ->whereYear('created_at','<=', $sampai[0])
                        ->where(['kegiatan_id' => $v->id, 'belanja_id' => $obj->id])
                        ->sum('total_anggaran');

                    $sql_serapan_regular = DinasRegular::whereMonth('created_at','>=', $dari[1])
                        ->whereYear('created_at','>=', $dari[0])
                        ->whereMonth('created_at','<=', $sampai[1])
                        ->whereYear('created_at','<=', $sampai[0])
                        ->where(['kegiatan_id' => $v->id, 'belanja_id' => $obj->id])
                        ->get();

                    if (count($sql_serapan_regular) > 0) {
                        foreach ($sql_serapan_regular as $o) {
                            $total_regular += $o->total_harian + $o->total_akomodasi + $o->total_transportasi['total'];
                        }
                    }

                    $anggaran_int = intval($sql_anggaran);
                    $serapan_int = intval($total_regular + $sql_serapan_bop);
                    $sisa_int = intval($sql_anggaran) - intval($total_regular + $sql_serapan_bop);

                    $result = [
                        'bendahara' => $v->pegawai->nama,
                        'kegiatan' => $v->nama_kegiatan,
                        'belanja' => $obj->nama_belanja,
                        'anggaran' => $anggaran_int,
                        'serapan' => $serapan_int,
                        'sisa' => $sisa_int
                    ];

                    array_push($output, $result);
                }
            }
            return view('excel', ['data' => $output, 'dari' => $dari[1], 'sampai' => $sampai[1], 'tahun' => $sampai[0]]);
        } else {
            return false;
        }
    }
}
