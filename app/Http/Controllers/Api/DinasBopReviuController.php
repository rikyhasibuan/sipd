<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopReviu;
use Illuminate\Http\Request;
use Exception;

class DinasBopReviuController extends Controller
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

        $timdinasbop = $timdinas->generate_reviu_bop($parameter);

        $dinasbopreviu = new DinasBopReviu();
        $dinasbopreviu->dinasbop_id = $request['dinasbop'];
        $dinasbopreviu->nomor_sp = $request->input('nomor_sp');
        $dinasbopreviu->tgl_sp = $request->input('tgl_sp');
        $dinasbopreviu->dari = $request->input('dari');
        $dinasbopreviu->sampai = $request->input('sampai');
        $dinasbopreviu->dasar = $dasar;
        $dinasbopreviu->tujuan = $tujuan;
        $dinasbopreviu->tim = $timdinasbop['reviu'];
        $dinasbopreviu->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopreviu->created_at = date('Y-m-d H:i:s');

        if ($dinasbopreviu->save()) {
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

        $timdinasbop = $timdinas->generate_reviu_bop($parameter);
        $dasar = array_values(array_filter($request->input('dasar')));
        $tujuan = array_values(array_filter($request->input('tujuan')));

        $dinasbopreviu = DinasBopReviu::find($request['id']);

        $biaya_bop_lama = $dinasbopreviu->total_anggaran;

        $dinasbopreviu->dinasbop_id = $request['dinasbop'];
        $dinasbopreviu->nomor_sp = $request->input('nomor_sp');
        $dinasbopreviu->tgl_sp = $request->input('tgl_sp');
        $dinasbopreviu->dari = $request->input('dari');
        $dinasbopreviu->sampai = $request->input('sampai');
        $dinasbopreviu->dasar = $dasar;
        $dinasbopreviu->tujuan = $tujuan;
        $dinasbopreviu->tim = $timdinasbop['reviu'];
        $dinasbopreviu->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopreviu->updated_at = date('Y-m-d H:i:s');

        if ($dinasbopreviu->save()) {
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
            $dinasbopreviu = DinasBopReviu::find($request['id']);
            $dinasbop_id = $dinasbopreviu->dinasbop_id;
            $anggaran_tim = $dinasbopreviu->total_anggaran;
            if ($dinasbopreviu->delete()) {
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
