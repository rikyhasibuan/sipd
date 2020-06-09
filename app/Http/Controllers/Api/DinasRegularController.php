<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\TimDinas;
use App\Models\DinasRegular;
use App\Models\DinasRegularApproval;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Libraries\Common;

class DinasRegularController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    /**
     * menampilkan semua data dinas regular
     * @param Request $request
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function show_data(Request $request)
    {
        return response()->json(DinasRegular::find($request['id']), 200);
    }

    /**
     * simpan data dinas regular
     * @param Request $request
     * @return JsonResponse
     */
    public function post_data(Request $request)
    {
        try {
            $timdinas = new TimDinas();
            $parameter = [
                'auditan'=> $request->input('auditan'),
                'tim' => $request->input('tim'),
                'dari' => $request->input('dari'),
                'sampai' => $request->input('sampai'),
                'id' => '',
                'act' => 'create'
            ];

            $timdinasregular = $timdinas->generate_tim_regular($parameter);
            $dasar = array_values(array_filter($request->input('dasar')));
            $untuk = array_values(array_filter($request->input('untuk')));

            $dinasregular = new DinasRegular();
            $dinasregular->program_id = $request->input('program_id');
            $dinasregular->kegiatan_id = $request->input('kegiatan_id');
            $dinasregular->belanja_id = $request->input('belanja_id');
            $dinasregular->nomor_sp = $request->input('nomor_sp');
            $dinasregular->tgl_sp = $request->input('tgl_sp');
            $dinasregular->dasar = $dasar;
            $dinasregular->untuk = $untuk;
            $dinasregular->auditan = $request->input('auditan');
            $dinasregular->dari = $request->input('dari');
            $dinasregular->sampai = $request->input('sampai');
            $dinasregular->tim = $timdinasregular['tim'];
            $dinasregular->total_transportasi = ['jenis_transportasi' => '', 'total'=> 0];
            $dinasregular->total_harian = $timdinasregular['total_harian'];
            $dinasregular->total_akomodasi = $timdinasregular['total_akomodasi'];
            $dinasregular->created_at = date('Y-m-d H:i:s');
            if ($dinasregular->save()) {
                $payload = [
                    'page' => 'Dinas Reguler',
                    'message' => 'User dengan NIP '.$request->query('nip').' menambahkan data baru pada Dinas Reguler'
                ];
                $this->_common->generate_log($payload);
                $timdinas->generate_approval_regular($dinasregular->id);
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * ubah data dinas regular
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function put_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'auditan' => $request->input('auditan'),
            'tim' => $request->input('tim'),
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'id' => $request['id'],
            'act' => 'put'
        ];

        $timdinasregular = $timdinas->generate_tim_regular($parameter);

        $dasar = array_values(array_filter($request->input('dasar')));
        $untuk = array_values(array_filter($request->input('untuk')));

        $dinasregular = DinasRegular::find($request['id']);
        $dinasregular->program_id = $request->input('program_id');
        $dinasregular->kegiatan_id = $request->input('kegiatan_id');
        $dinasregular->belanja_id = $request->input('belanja_id');
        $dinasregular->nomor_sp = $request->input('nomor_sp');
        $dinasregular->tgl_sp = $request->input('tgl_sp');
        $dinasregular->dasar = $dasar;
        $dinasregular->untuk = $untuk;
        $dinasregular->auditan = $request->input('auditan');
        $dinasregular->dari = $request->input('dari');
        $dinasregular->sampai = $request->input('sampai');
        $dinasregular->tim = $timdinasregular['tim'];
        $dinasregular->total_transportasi = ['jenis_transportasi' => '', 'total' => 0];
        $dinasregular->total_harian = $timdinasregular['total_harian'];
        $dinasregular->total_akomodasi = $timdinasregular['total_akomodasi'];
        $dinasregular->updated_at = date('Y-m-d H:i:s');
        if ($dinasregular->save()) {
            $payload = [
                'page' => 'Dinas Reguler',
                'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan data pada Dinas Reguler'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    /**
     * ubah data dinas regular
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function delete_data(Request $request)
    {
        $dinasregular = DinasRegular::find($request['id']);
        if ($dinasregular->delete()) {
            $payload = [
                'page' => 'Dinas Reguler',
                'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pada Dinas Reguler'
            ];
            DinasRegularApproval::where('dinasregular_id', $request['id'])->delete();
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    /**
     * ubah data transportasi pada dinas regular
     * @param Request $request
     * @return JsonResponse
     */
    public function put_transportasi_data(Request $request)
    {
        $dinasregular = DinasRegular::find($request['id']);
        $_durasi = ($request->input('durasi') !== '') ? $request->input('durasi') : '';
        $_jenis = ($request->input('jenis') !== '') ? $request->input('jenis') : '';
        $_liter = ($request->input('liter') !== 0) ? $request->input('liter') : 0;
        $_total = $request->input('total');

        switch ($_jenis) {
            case 'BBM':
                $transportasi = ['total' => intval($_total), 'liter' => $_liter, 'jenis' => 'BBM'];
                break;
            case 'Sewa Kendaraan':
                $transportasi = ['total' => intval($_total), 'liter' => 0, 'jenis' => 'Sewa Kendaraan'];
                break;
            case 'Tiket':
                $transportasi = ['total' => intval($_total), 'liter' => 0, 'jenis' => 'Tiket'];
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
            $payload = [
                'page' => 'Dinas Reguler',
                'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan transportasi pada Dinas Reguler'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
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

    public function put_approval_data(Request $request)
    {
        $act = $request['act'];
        $type = $request['type'];
        $dinasregular_id = $request['id'];

        if ($act == 'revision') {
            $approvalregular = DinasRegularApproval::where('dinasregular_id', $dinasregular_id)->first();
            $column = $approvalregular[$type];
            array_push($column['catatan'], ['text'=>$request->input('catatan'), 'date' => date('Y-m-d H:i:s')]);
            $primary_id = $approvalregular['id'];

            $dinasregularrevision = DinasRegularApproval::find($primary_id);
            $dinasregularrevision->{$type} = $column;
            $dinasregularrevision->updated_at = date('Y-m-d H:i:s');

            if ($dinasregularrevision->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }

        } else if ($act == 'approve') {
            $approvalregular = DinasRegularApproval::where('dinasregular_id', $dinasregular_id)->first();
            $column = $approvalregular[$type];
            $column['approval'] = 1;
            $primary_id = $approvalregular['id'];

            $dinasregularapproval = DinasRegularApproval::find($primary_id);
            $dinasregularapproval->{$type} = $column;
            $dinasregularapproval->updated_at = date('Y-m-d H:i:s');
            if ($dinasregularapproval->save()) {
                $dinasregularlock = DinasRegularApproval::find($primary_id);
                $i = 0;
                if ($dinasregularlock->inspektur['approval'] == 1) {
                    $i++;
                }
                if ($dinasregularlock->sekretaris['approval'] == 1) {
                    $i++;
                }
                if ($dinasregularlock->kassubag['approval'] == 1) {
                    $i++;
                }

                if ($i == 3) {
                    $dinasregularlock->lock = 1;
                    if ($dinasregularlock->save()) {
                        DinasRegular::where('id', $dinasregular_id)->update(['status' => 1]);
                    }
                }

                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        }
    }
}
