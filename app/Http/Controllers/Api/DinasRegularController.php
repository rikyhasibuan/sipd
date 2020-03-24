<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\TimDinas;
use App\Models\DinasRegular;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DinasRegularController extends Controller
{
    /**
     * menampilkan semua data dinas regular
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_data(Request $request)
    {
        try {
            $_program = ($request['program'] !== '') ? $request['program'] : '';
            $_kegiatan = ($request['kegiatan'] !== '') ? $request['kegiatan'] : '';
            $_belanja = ($request['belanja'] !== '') ? $request['belanja'] : '';

            $dinasbop = DinasRegular::searchKegiatan($_kegiatan)
                                    ->searchProgram($_program)
                                    ->searchBelanja($_belanja)
                                    ->with('program', 'kegiatan', 'belanja')
                                    ->orderBy('id', 'DESC')
                                    ->paginate(10);

            return response()->json($dinasbop, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * menampilkan data dinas berdasarkan id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show_data(Request $request)
    {
        return response()->json(DinasRegular::find($request['id']), 200);
    }

    /**
     * simpan data dinas regular
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'auditan'=> $request->input('auditan'),
                        'tim' => $request->input('tim'),
                        'dari' => $request->input('dari'),
                        'sampai' => $request->input('sampai')
                    ];
        
        $timdinasregular = $timdinas->generate_tim_regular($parameter);

        $dinasregular = new DinasRegular();
        $dinasregular->program_id = $request->input('program_id');
        $dinasregular->kegiatan_id = $request->input('kegiatan_id');
        $dinasregular->belanja_id = $request->input('belanja_id');
        $dinasregular->nomor_sp = $request->input('nomor_sp');
        $dinasregular->tgl_sp = $request->input('tgl_sp');
        $dinasregular->dasar = $request->input('dasar');
        $dinasregular->untuk = $request->input('untuk');
        $dinasregular->auditan = $request->input('auditan');
        $dinasregular->dari = $request->input('dari');
        $dinasregular->sampai = $request->input('sampai');
        $dinasregular->tim = $timdinasregular['tim'];
        $dinasregular->total_transportasi = ['jenis_transportasi' => '', 'total'=> 0 ];
        $dinasregular->total_harian = $timdinasregular['total_harian'];
        $dinasregular->total_akomodasi = $timdinasregular['total_akomodasi'];
        $dinasregular->created_at = date('Y-m-d H:i:s');

        if ($dinasregular->save()) {
            return response()->json(['status'=>'OK'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    /**
     * ubah data dinas regular
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'auditan' => $request->input('auditan'),
            'tim' => $request->input('tim'),
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai')
        ];

        $timdinasregular = $timdinas->generate_tim_regular($parameter);

        $dinasregular = DinasRegular::find($request['id']);
        $dinasregular->program_id = $request->input('program_id');
        $dinasregular->kegiatan_id = $request->input('kegiatan_id');
        $dinasregular->belanja_id = $request->input('belanja_id');
        $dinasregular->nomor_sp = $request->input('nomor_sp');
        $dinasregular->tgl_sp = $request->input('tgl_sp');
        $dinasregular->dasar = $request->input('dasar');
        $dinasregular->untuk = $request->input('untuk');
        $dinasregular->auditan = $request->input('auditan');
        $dinasregular->dari = $request->input('dari');
        $dinasregular->sampai = $request->input('sampai');
        $dinasregular->tim = $timdinasregular['tim'];
        $dinasregular->total_transportasi = ['jenis_transportasi' => '', 'total' => 0];
        $dinasregular->total_harian = $timdinasregular['total_harian'];
        $dinasregular->total_akomodasi = $timdinasregular['total_akomodasi'];
        $dinasregular->updated_at = date('Y-m-d H:i:s');
        if ($dinasregular->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    /**
     * ubah data dinas regular
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_data(Request $request)
    {
        $dinasregular = DinasRegular::find($request['id']);
        if ($dinasregular->delete()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    /**
     * ubah data transportasi pada dinas regular
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put_transportasi_data(Request $request)
    {
        $dinasregular = DinasRegular::find($request['id']);
        $_durasi = ($request->input('durasi') !== '') ? $request->input('durasi') : '';
        $_jenis = ($request->input('jenis') !== '') ? $request->input('jenis') : '';
        $_liter = ($request->input('liter') !== 0) ? $request->input('liter') : 0;
        $_total = $request->input('total');
        
        $transportasi = [];

        switch ($_jenis) {
            case 'BBM':
                $transportasi = ['total' => $_total, 'liter' => $_liter, 'jenis' => 'BBM'];
                break;
            case 'Travel':
                $transportasi = ['total' => $_total, 'liter' => 0, 'jenis' => 'Travel'];
                break;
            case 'Tiket':
                $transportasi = ['total' => $_total, 'liter' => 0, 'jenis' => 'Tiket'];
                break;
            default:
                $transportasi = ['total' => 0, 'liter' => 0, 'jenis' => ''];
                break;
        }

        $timdinasregular = new TimDinas();
        $anggaran_akomodasi = $timdinasregular->calculate_regular_accomodation($_durasi, $dinasregular->auditan, $dinasregular->tim);
        $dinasregular->tim = $anggaran_akomodasi['tim'];
        $dinasregular->total_akomodasi = $anggaran_akomodasi['akomodasi'];
        $dinasregular->lama_inap = $_durasi;
        $dinasregular->total_transportasi = $transportasi;
        if ($dinasregular->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function get_print_sp(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasregular = DinasRegular::find($_id);
            return View::make('dinasregular.sp', ['dinasregular' => $dinasregular]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_spd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasregular = DinasRegular::find($_id);
            return View::make('dinasregular.spd', ['dinasregular'=>$dinasregular]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_rbpd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasregular = DinasRegular::find($_id);
            return View::make('dinasregular.rbpd', ['dinasregular'=>$dinasregular]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_personil(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasregular = DinasRegular::find($_id);
            return View::make('dinasregular.daftar_personil', ['dinasregular'=>$dinasregular]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_dpbo(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasregular = DinasRegular::find($_id);
            return View::make('dinasregular.dpbo', ['dinasregular'=>$dinasregular]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
