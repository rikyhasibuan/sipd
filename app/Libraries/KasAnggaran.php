<?php

namespace App\Libraries;

/**
 * Description of KasAnggaran
 *
 * @author rikyhsb
 */

use App\Models\Anggaran;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use App\Models\DinasRegular;

class KasAnggaran
{
    /**
     * menampilkan sisa anggaran sesuai dengan tahun dan kode belanja
     * @param string $tahun
     * @param int $bulan
     * @param string $belanja
     * @return int
     */
    function show_sisa_anggaran($tahun, $bulan, $belanja)
    {
        $anggaran = self::show_total_anggaran($tahun, $bulan, $belanja);
        $resapan_anggaran = self::show_resapan_anggaran($tahun, $bulan, $belanja);

        return ($anggaran - $resapan_anggaran);
    }

    /**
     * menampilkan total anggaran untuk tahun dan kode belanja tertentu
     * @param string $tahun
     * @param int $bulan
     * @param string $belanja
     * @return int $anggaran
     */
    function show_total_anggaran($tahun, $bulan, $belanja)
    {
        if ($bulan != '') {
            $anggaran = Anggaran::searchBelanja($belanja)->searchTahun($tahun)->searchBulan($bulan)->first();
            return $anggaran['jumlah'];
        } else {
            $anggaran = Anggaran::searchBelanja($belanja)->searchTahun($tahun)->searchBulan($bulan)->sum('jumlah');
            return $anggaran;
        }
    }

    /**
     * menampilkan akumulasi anggaran yang digunakan berdasarkan tahun dan kode belanja tertentu
     * @param string $tahun
     * @param string $bulan
     * @param string $belanja
     * @return integer $resapan_anggaran
     */
    function show_resapan_anggaran($tahun, $bulan, $belanja)
    {
        $dinasbop = DinasBop::searchBelanja($belanja)->searchTahun($tahun)->get();
        $dinasregular = DinasRegular::searchBelanja($belanja)->searchTahun($tahun)->get();

        $anggaran_bop = 0;
        if (count($dinasbop) > 0) {
            foreach ($dinasbop as $v) {
                $anggaran_bop += $v->total_anggaran;
            }
        }

        $anggaran_regular = 0;
        if (count($dinasregular) > 0) {
            foreach ($dinasregular as $x) {
                $anggaran_regular += ($x->total_harian + $x->total_akomodasi + $x->total_transportasi['total']);
            }
        }

        return ($anggaran_bop + $anggaran_regular);
    }

    /**
     * mengecek apakah sisa anggaran mencukupi untuk biaya dinas
     * @param string $tahun
     * @param int $bulan
     * @param string $belanja
     * @return boolean
     */
    public function show_ketersediaan_anggaran($tahun, $bulan, $belanja)
    {
        $anggaran = self::show_total_anggaran($tahun, $bulan, $belanja);
        $resapan_anggaran = self::show_resapan_anggaran($tahun, $bulan, $belanja);

        $sisa_anggaran = $anggaran - $resapan_anggaran;
        if ($sisa_anggaran <= 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * mengakumulasi biaya anggaran pada dinas bop tertentu
     * @param int $id
     * @return int
     */
    public function show_biaya_bop($id)
    {
        return DinasBopTim::where('dinasbop_id', $id)->sum('total_anggaran');
    }
    

    /**
     * mengecek apakah sisa anggaran mencukupi untuk biaya dinas
     * @param string $tahun
     * @param string $belanja
     * @return boolean
     */
    public function calculate_available_fee($tahun, $bulan, $belanja, $total_biaya)
    {
        $anggaran = self::show_sisa_anggaran($tahun, $bulan, $belanja);
        $sisa_anggaran = $anggaran - $total_biaya;
        if ($sisa_anggaran <= 0) {
            return false;
        } else {
            return true;
        }
    }
}
