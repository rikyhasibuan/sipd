<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopPengumpulData;
use App\Models\DinasBopPengumpulDataTim;
use Illuminate\Http\Request;
use Exception;

class DinasBopPengumpulDataController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function post_data(Request $request)
    {
        try {
            $dasar = array_values(array_filter($request->input('dasar')));
            $untuk = array_values(array_filter($request->input('untuk')));

            $dinasboppengumpuldata = new DinasBopPengumpulData();
            $dinasboppengumpuldata->dinasbop_id = $request['dinasbop'];
            $dinasboppengumpuldata->dasar = $dasar;
            $dinasboppengumpuldata->untuk = $untuk;
            $dinasboppengumpuldata->dari = $request->input('dari');
            $dinasboppengumpuldata->sampai = $request->input('sampai');
            $dinasboppengumpuldata->created_at = date('Y-m-d H:i:s');
            if ($dinasboppengumpuldata->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        $dasar = array_values(array_filter($request->input('dasar')));
        $untuk = array_values(array_filter($request->input('untuk')));

        $dinasbop = DinasBopPengumpulData::find($request['id']);
        $dinasbop->dinasbop_id = $request['dinasbop'];
        $dinasbop->dasar = $dasar;
        $dinasbop->untuk = $untuk;
        /* $dinasbop->dari = $request->input('dari');
        $dinasbop->sampai = $request->input('sampai'); */
        $dinasbop->updated_at = date('Y-m-d H:i:s');

        if ($dinasbop->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $anggaran = DinasBopPengumpulData::find($request['id']);
            $parent = $anggaran->id;
            if ($anggaran->delete()) {
                DinasBopPengumpulDataTim::where('dinasbop_pengumpuldata_id', $parent)->delete();
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_tim_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'idtim' => '',
            'pengumpuldata' => $request['pengumpuldata'],
            'dinasbop' => $request['dinasbop'],
            'auditan'=> $request->input('auditan'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => json_decode($request->input('anggota'), true),
            'act' => 'create'
        ];

        $timdinasbop = $timdinas->generate_pengumpuldata_bop($parameter);
        $dinasboptim = new DinasBopPengumpulDataTim();
        $dinasboptim->dinasbop_id = $request['dinasbop'];
        $dinasboptim->dinasbop_pengumpuldata_id = $request['pengumpuldata'];
        $dinasboptim->auditan = $request->input('auditan');
        $dinasboptim->nomor_sp = $request->input('nomor_sp');
        $dinasboptim->tgl_sp = $request->input('tgl_sp');
        $dinasboptim->tim = $timdinasbop['tim'];
        $dinasboptim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptim->created_at = date('Y-m-d H:i:s');
        if ($dinasboptim->save()) {
            $dinasboppengumpuldata = DinasBopPengumpulData::find($request['pengumpuldata']);
            $biaya_pengumpuldata_lama = $dinasboppengumpuldata->total_anggaran;
            $dinasboppengumpuldata->total_anggaran = $biaya_pengumpuldata_lama + $timdinasbop['total_anggaran'];
            if ($dinasboppengumpuldata->save()) {
                $dinasbop = DinasBop::find($request['dinasbop']);
                $biaya_bop_lama = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $biaya_bop_lama + $timdinasbop['total_anggaran'];
                $dinasbop->save();
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_tim_data(Request $request)
    {
        $dinasboptimpengumpuldata = DinasBopPengumpulDataTim::find($request['id']);
        $timdinas = new TimDinas();
        $parameter = [
            'idtim' => $request['id'],
            'dinasbop' => $dinasboptimpengumpuldata->dinasbop_id,
            'pengumpuldata' => $request['pengumpuldata'],
            'auditan'=> $request->input('auditan'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => $request->input('anggota'),
            'act' => 'put'
        ];

        $timdinasbop = $timdinas->generate_pengumpuldata_bop($parameter);

        $anggaran_pengumpuldata_lama = $dinasboptimpengumpuldata->total_anggaran;

        $dinasboptimpengumpuldata->auditan = $request->input('auditan');
        $dinasboptimpengumpuldata->nomor_sp = $request->input('nomor_sp');
        $dinasboptimpengumpuldata->tgl_sp = $request->input('tgl_sp');
        $dinasboptimpengumpuldata->tim = $timdinasbop['tim'];
        $dinasboptimpengumpuldata->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptimpengumpuldata->updated_at = date('Y-m-d H:i:s');
        if ($dinasboptimpengumpuldata->save()) {
            $dinasboppengumpuldata = DinasBopPengumpulData::find($request['pengumpuldata']);
            $biaya_pengumpuldata_lama = $dinasboppengumpuldata->total_anggaran;
            $dinasboppengumpuldata->total_anggaran = $biaya_pengumpuldata_lama - $anggaran_pengumpuldata_lama + $timdinasbop['total_anggaran'];
            if ($dinasboppengumpuldata->save()) {
                $dinasbop = DinasBop::find($dinasboptimpengumpuldata->dinasbop_id);
                $anggaran_bop_lama = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $anggaran_bop_lama - $anggaran_pengumpuldata_lama + $timdinasbop['total_anggaran'];
                if ($dinasbop->save()) {
                    return response()->json(['status' => 'ok'], 200);
                } else {
                    return response()->json(['status' => 'failed'], 500);
                }
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_tim_data(Request $request)
    {
        try {
            $dinasboptim = DinasBopPengumpulDataTim::find($request['id']);
            $dinasbop_id = $dinasboptim->dinasbop_id;
            $dinasboppengumpuldata_id = $dinasboptim->dinasbop_pengumpuldata_id;
            $anggaran_tim = $dinasboptim->total_anggaran;
            if ($dinasboptim->delete()) {
                $pengumpuldata = DinasBopPengumpulData::find($dinasboppengumpuldata_id);
                $total_anggaran = $pengumpuldata->total_anggaran;
                $pengumpuldata->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $pengumpuldata->save();

                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $dinasbop->save();
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
