<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopAdministrasi;
use App\Models\DinasBopAdministrasiTim;
use Illuminate\Http\Request;
use Exception;

class DinasBopAdministrasiController extends Controller
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

            $dinasbopadministrasi = new DinasBopAdministrasi();
            $dinasbopadministrasi->dinasbop_id = $request['dinasbop'];
            $dinasbopadministrasi->dasar = $dasar;
            $dinasbopadministrasi->untuk = $untuk;
            $dinasbopadministrasi->dari = $request->input('dari');
            $dinasbopadministrasi->sampai = $request->input('sampai');
            $dinasbopadministrasi->created_at = date('Y-m-d H:i:s');
            if ($dinasbopadministrasi->save()) {
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

        $dinasbopadministrasi = DinasBopAdministrasi::find($request['id']);
        $dinasbopadministrasi->dinasbop_id = $request['dinasbop'];
        $dinasbopadministrasi->dasar = $dasar;
        $dinasbopadministrasi->untuk = $untuk;
        /* $dinasbopadministrasi->dari = $request->input('dari');
        $dinasbopadministrasi->sampai = $request->input('sampai'); */
        $dinasbopadministrasi->updated_at = date('Y-m-d H:i:s');

        if ($dinasbopadministrasi->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $anggaran = DinasBopAdministrasi::find($request['id']);
            $parent = $anggaran->id;
            if ($anggaran->delete()) {
                DinasBopAdministrasiTim::where('dinasbop_administrasi_id', $parent)->delete();
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
            'administrasi' => $request['administrasi'],
            'dinasbop' => $request['dinasbop'],
            'auditan'=> $request->input('auditan'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => json_decode($request->input('anggota'), true),
            'act' => 'create'
        ];

        $timdinasbop = $timdinas->generate_administrasi_bop($parameter);
        $dinasboptim = new DinasBopAdministrasiTim();
        $dinasboptim->dinasbop_id = $request['dinasbop'];
        $dinasboptim->dinasbop_administrasi_id = $request['administrasi'];
        $dinasboptim->auditan = $request->input('auditan');
        $dinasboptim->nomor_sp = $request->input('nomor_sp');
        $dinasboptim->tgl_sp = $request->input('tgl_sp');
        $dinasboptim->tim = $timdinasbop['tim'];
        $dinasboptim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptim->created_at = date('Y-m-d H:i:s');
        if ($dinasboptim->save()) {
            $dinasbopadministrasi = DinasBopAdministrasi::find($request['administrasi']);
            $biaya_administrasi_lama = $dinasbopadministrasi->total_anggaran;
            $dinasbopadministrasi->total_anggaran = $biaya_administrasi_lama + $timdinasbop['total_anggaran'];
            if ($dinasbopadministrasi->save()) {
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
        $dinasboptimadministrasi = DinasBopAdministrasiTim::find($request['id']);
        $timdinas = new TimDinas();
        $parameter = [
            'idtim' => $request['id'],
            'dinasbop' => $dinasboptimadministrasi->dinasbop_id,
            'administrasi' => $request['administrasi'],
            'auditan'=> $request->input('auditan'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => $request->input('anggota'),
            'act' => 'put'
        ];

        $timdinasbop = $timdinas->generate_administrasi_bop($parameter);

        $anggaran_administrasi_lama = $dinasboptimadministrasi->total_anggaran;

        $dinasboptimadministrasi->auditan = $request->input('auditan');
        $dinasboptimadministrasi->nomor_sp = $request->input('nomor_sp');
        $dinasboptimadministrasi->tgl_sp = $request->input('tgl_sp');
        $dinasboptimadministrasi->tim = $timdinasbop['tim'];
        $dinasboptimadministrasi->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptimadministrasi->updated_at = date('Y-m-d H:i:s');
        if ($dinasboptimadministrasi->save()) {
            $dinasbopadministrasi = DinasBopAdministrasi::find($request['administrasi']);
            $biaya_administrasi_lama = $dinasbopadministrasi->total_anggaran;
            $dinasbopadministrasi->total_anggaran = $biaya_administrasi_lama - $anggaran_administrasi_lama + $timdinasbop['total_anggaran'];
            if ($dinasbopadministrasi->save()) {
                $dinasbop = DinasBop::find($dinasbopadministrasi->dinasbop_id);
                $anggaran_bop_lama = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $anggaran_bop_lama - $anggaran_administrasi_lama + $timdinasbop['total_anggaran'];
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
            $dinasboptim = DinasBopAdministrasiTim::find($request['id']);
            $dinasbop_id = $dinasboptim->dinasbop_id;
            $dinasbopadministrasi_id = $dinasboptim->dinasbop_administrasi_id;
            $anggaran_tim = $dinasboptim->total_anggaran;
            if ($dinasboptim->delete()) {
                $administrasi = DinasBopAdministrasi::find($dinasbopadministrasi_id);
                $total_anggaran = $administrasi->total_anggaran;
                $administrasi->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $administrasi->save();

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
