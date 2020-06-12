<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopCustomTim;
use Illuminate\Http\Request;
use Exception;

class DinasBopCustomController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function post_data(Request $request)
    {
        $path = $request->file('lampiran')->store('public/lampiran_dinas/bop');

        $timdinas = new TimDinas();
        $parameter = [
            'dinasbop' => $request['dinasbop'],
            'idtim' => '',
            'auditan'=> $request->input('auditan'),
            'penanggungjawab' => $request->input('penanggungjawab'),
            'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
            'pengendaliteknis' => $request->input('pengendaliteknis'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => json_decode($request->input('anggota'), true),
            'act' => 'create'
        ];

        $timdinasbop = $timdinas->generate_tim_custom_bop($parameter);
        $dinasbopcustomtim = new DinasBopCustomTim();
        $dinasbopcustomtim->dinasbop_id = $request['dinasbop'];
        $dinasbopcustomtim->auditan = $request->input('auditan');
        $dinasbopcustomtim->nomor_sp = $request->input('nomor_sp');
        $dinasbopcustomtim->tgl_sp = $request->input('tgl_sp');
        $dinasbopcustomtim->tim = $timdinasbop['tim'];
        $dinasbopcustomtim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopcustomtim->lampiran = $path;
        $dinasbopcustomtim->created_at = date('Y-m-d H:i:s');
        if ($dinasbopcustomtim->save()) {
            $payload = [
                'page' => 'Dinas BOP - Kustomisasi',
                'message' => 'User dengan NIP '.$request->query('nip').' menambahkan tim baru pada Dinas BOP Kustomisasi'
            ];
            $this->_common->generate_log($payload);

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
            'dinasbop' => $request['dinasbop'],
            'idtim' => $request['id'],
            'auditan' => $request->input('auditan'),
            'penanggungjawab' => $request->input('penanggungjawab'),
            'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
            'pengendaliteknis' => $request->input('pengendaliteknis'),
            'ketuatim' => $request->input('ketuatim'),
            'anggota' => json_decode($request->input('anggota'), true),
            'act' => 'put'
        ];

        $timdinasbop = $timdinas->generate_tim_custom_bop($parameter);

        $dinasbopcustomtim = DinasBopCustomTim::find($request['id']);
        $biaya_bop_lama = $dinasbopcustomtim->total_anggaran;

        $dinasbopcustomtim->dinasbop_id = $request['dinasbop'];
        $dinasbopcustomtim->auditan = $request->input('auditan');
        $dinasbopcustomtim->nomor_sp = $request->input('nomor_sp');
        $dinasbopcustomtim->tgl_sp = $request->input('tgl_sp');
        $dinasbopcustomtim->tim = $timdinasbop['tim'];

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('public/lampiran_dinas/bop');
            $dinasbopcustomtim->lampiran = $path;
        }

        $dinasbopcustomtim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasbopcustomtim->updated_at = date('Y-m-d H:i:s');

        if ($dinasbopcustomtim->save()) {
            $dinasbop = DinasBop::find($request['dinasbop']);
            $anggaran_bop_lama = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $anggaran_bop_lama - $biaya_bop_lama + $timdinasbop['total_anggaran'];

            if ($dinasbop->save()) {
                $payload = [
                    'page' => 'Dinas BOP - Kustomisasi',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan tim pada Dinas BOP Kustomisasi'
                ];
                $this->_common->generate_log($payload);

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
            $dinasbopcustomtim = DinasBopCustomTim::find($request['id']);
            $dinasbop_id = $dinasbopcustomtim->dinasbop_id;
            $anggaran_tim = $dinasbopcustomtim->total_anggaran;
            if ($dinasbopcustomtim->delete()) {
                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $dinasbop->save();

                $payload = [
                    'page' => 'Dinas BOP - Kustomisasi',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus tim pada Dinas BOP Kustomisasi'
                ];
                $this->_common->generate_log($payload);

                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
