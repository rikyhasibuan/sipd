<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopSupervisi;
use Illuminate\Http\Request;
use Exception;

class DinasBopSupervisiController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function post_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'idtim' => '',
            'dinasbop' => $request['dinasbop'],
            'dari'=>$request->input('dari'),
            'sampai'=>$request->input('sampai'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => $request->input('anggota'),
            'act' => 'create'
        ];

        $dasar = array_values(array_filter($request->input('dasar')));
        $tujuan = array_values(array_filter($request->input('tujuan')));

        $timdinasbop = $timdinas->generate_supervisi_bop($parameter);

        $dinasbopsupervisi = new DinasBopSupervisi();
        $dinasbopsupervisi->dinasbop_id = $request['dinasbop'];
        $dinasbopsupervisi->nomor_sp = $request->input('nomor_sp');
        $dinasbopsupervisi->tgl_sp = $request->input('tgl_sp');
        $dinasbopsupervisi->dari = $request->input('dari');
        $dinasbopsupervisi->sampai = $request->input('sampai');
        $dinasbopsupervisi->dasar = $dasar;
        $dinasbopsupervisi->tujuan = $tujuan;
        $dinasbopsupervisi->tim = $timdinasbop['supervisi'];
        $dinasbopsupervisi->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopsupervisi->created_at = date('Y-m-d H:i:s');

        if ($dinasbopsupervisi->save()) {
            $dinasbop = DinasBop::find($request['dinasbop']);
            $biaya_bop_lama = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $biaya_bop_lama + $timdinasbop['total_anggaran'];
            if ($dinasbop->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'idtim' => $request['id'],
            'dinasbop' => $request['dinasbop'],
            'dari'=>$request->input('dari'),
            'sampai'=>$request->input('sampai'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => $request->input('anggota'),
            'act' => 'put'
        ];

        $timdinasbop = $timdinas->generate_supervisi_bop($parameter);
        $dasar = array_values(array_filter($request->input('dasar')));
        $tujuan = array_values(array_filter($request->input('tujuan')));

        $dinasbopsupervisi = DinasBopSupervisi::find($request['id']);

        $biaya_bop_lama = $dinasbopsupervisi->total_anggaran;

        $dinasbopsupervisi->dinasbop_id = $request['dinasbop'];
        $dinasbopsupervisi->nomor_sp = $request->input('nomor_sp');
        $dinasbopsupervisi->tgl_sp = $request->input('tgl_sp');
        $dinasbopsupervisi->dari = $request->input('dari');
        $dinasbopsupervisi->sampai = $request->input('sampai');
        $dinasbopsupervisi->dasar = $dasar;
        $dinasbopsupervisi->tujuan = $tujuan;
        $dinasbopsupervisi->tim = $timdinasbop['supervisi'];
        $dinasbopsupervisi->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopsupervisi->updated_at = date('Y-m-d H:i:s');

        if ($dinasbopsupervisi->save()) {
            $dinasbop = DinasBop::find($request['dinasbop']);
            $anggaran_bop_lama = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $anggaran_bop_lama - $biaya_bop_lama + $timdinasbop['total_anggaran'];
            if ($dinasbop->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $dinasbopsupervisi = DinasBopSupervisi::find($request['id']);
            $dinasbop_id = $dinasbopsupervisi->dinasbop_id;
            $anggaran_tim = $dinasbopsupervisi->total_anggaran;
            if ($dinasbopsupervisi->delete()) {
                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $dinasbop->save();
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
