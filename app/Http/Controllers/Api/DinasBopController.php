<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Models\DinasBop;
use App\Models\DinasBopSupervisi;
use App\Models\DinasBopTim;
use App\Models\DinasBopCustomTim;
use App\Models\DinasBopDriver;
use App\Models\DinasBopInspektur;
use App\Models\DinasBopSekretaris;
use App\Models\DinasBopReviu;
use App\Models\DinasBopPengumpulData;
use App\Models\DinasBopPengumpulDataTim;
use App\Models\DinasBopAdministrasi;
use App\Models\DinasBopAdministrasiTim;
use App\Models\DinasBopApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Exception;

class DinasBopController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function get_data(Request $request)
    {
        try {
            $_program = ($request['program'] !== '') ? $request['program'] : '';
            $_kegiatan = ($request['kegiatan'] !== '') ? $request['kegiatan'] : '';
            $_belanja = ($request['belanja'] !== '') ? $request['belanja'] : '';

            $dinasbop = DinasBop::searchKegiatan($_kegiatan)
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

    public function show_data(Request $request)
    {
        return response()->json(DinasBop::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        try {
            $check = DinasBop::whereBetween('dari', [$request->input('dari'), $request->input('sampai')])
            ->orWhereBetween('sampai', [$request->input('dari'), $request->input('sampai')])->count();

            if ($check == 0) {
                $dasar = array_values(array_filter($request->input('dasar')));
                $untuk = array_values(array_filter($request->input('untuk')));

                $dinasbop = new DinasBop();
                $dinasbop->program_id = $request->input('program_id');
                $dinasbop->kegiatan_id = $request->input('kegiatan_id');
                $dinasbop->belanja_id = $request->input('belanja_id');
                $dinasbop->dasar = $dasar;
                $dinasbop->untuk = $untuk;
                $dinasbop->dari = $request->input('dari');
                $dinasbop->sampai = $request->input('sampai');
                $dinasbop->status = 0;
                $dinasbop->created_at = date('Y-m-d H:i:s');

                if ($dinasbop->save()) {
                    $timdinas = new TimDinas();
                    $timdinas->generate_approval_bop($dinasbop->id);

                    $payload = [
                        'page' => 'Dinas BOP',
                        'message' => 'User dengan NIP '.$request->query('nip').' menambahkan data Dinas BOP baru'
                    ];
                    $this->_common->generate_log($payload);

                    return response()->json(['status'=>'ok'], 200);
                } else {
                    return response()->json(['status'=>'failed'], 500);
                }
            } else {
                return response()->json(['status'=>'duplicate'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        $dasar = array_values(array_filter($request->input('dasar')));
        $untuk = array_values(array_filter($request->input('untuk')));

        $dinasbop = DinasBop::find($request['id']);
        $dinasbop->program_id = $request->input('program_id');
        $dinasbop->kegiatan_id = $request->input('kegiatan_id');
        $dinasbop->belanja_id = $request->input('belanja_id');
        $dinasbop->dasar = $dasar;
        $dinasbop->untuk = $untuk;
        $dinasbop->total_anggaran = 0;
        $dinasbop->updated_at = date('Y-m-d H:i:s');

        if ($dinasbop->save()) {
            $payload = [
                'page' => 'Dinas BOP',
                'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan pada data Dinas BOP'
            ];

            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $anggaran = DinasBop::find($request['id']);
            if ($anggaran->delete()) {
                DinasBopTim::where('dinasbop_id',  $request['id'])->delete();
                DinasBopDriver::where('dinasbop_id',  $request['id'])->delete();
                DinasBopInspektur::where('dinasbop_id',  $request['id'])->delete();
                DinasBopSekretaris::where('dinasbop_id',  $request['id'])->delete();
                DinasBopReviu::where('dinasbop_id',  $request['id'])->delete();
                DinasBopSupervisi::where('dinasbop_id',  $request['id'])->delete();
                DinasBopPengumpulData::where('dinasbop_id',  $request['id'])->delete();
                DinasBopPengumpulDataTim::where('dinasbop_id',  $request['id'])->delete();
                DinasBopAdministrasi::where('dinasbop_id',  $request['id'])->delete();
                DinasBopAdministrasiTim::where('dinasbop_id',  $request['id'])->delete();
                DinasBopApproval::where('dinasbop_id',  $request['id'])->delete();

                $payload = [
                    'page' => 'Dinas BOP',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pada Dinas BOP'
                ];
                $this->_common->generate_log($payload);

                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_sp(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';

            $view = '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_tim.sp', ['dinasboptim'=>$dinasboptim]);
                    break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_driver.sp', ['dinasbopdriver'=>$dinasbopdriver]);
                    break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_inspektur.sp', ['dinasbopinspektur'=>$dinasbopinspektur]);
                    break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekretaris::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_sekretaris.sp', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                    break;
                case 'reviu':
                    $dinasbopreviu = DinasBopReviu::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_reviu.sp', ['dinasbopreviu'=>$dinasbopreviu]);
                    break;
                case 'supervisi':
                    $dinasbopsupervisi = DinasBopSupervisi::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_supervisi.sp', ['dinasbopsupervisi'=>$dinasbopsupervisi]);
                    break;
                case 'pengumpuldata':
                    $dinasboppengumpuldata = DinasBopPengumpulDataTim::with('dinasboppengumpuldata')->find($_id);
                    $view = View::make('dinasbop.print_pengumpuldata.sp', ['timpengumpuldata'=>$dinasboppengumpuldata]);
                    break;
                case 'administrasi':
                    $dinasbopadministrasi = DinasBopAdministrasiTim::with('dinasbopadministrasi')->find($_id);
                    $view = View::make('dinasbop.print_administrasi.sp', ['timadministrasi'=>$dinasbopadministrasi]);
                    break;
                case 'custom':
                    $dinasbopcustom = DinasBopCustomTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_custom.sp', ['dinasbopcustom'=>$dinasbopcustom]);
                    break;
            }

            return $view;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_spd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            $view = '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_tim.spd', ['dinasboptim'=>$dinasboptim]);
                break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_driver.spd', ['dinasbopdriver'=>$dinasbopdriver]);
                break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_inspektur.spd', ['dinasbopinspektur'=>$dinasbopinspektur]);
                break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekretaris::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_sekretaris.spd', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                break;
                case 'reviu':
                    $dinasbopreviu = DinasBopReviu::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_reviu.spd', ['dinasbopreviu'=>$dinasbopreviu]);
                break;
                case 'supervisi':
                    $dinasbopsupervisi = DinasBopSupervisi::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_supervisi.spd', ['dinasbopsupervisi'=>$dinasbopsupervisi]);
                    break;
                case 'pengumpuldata':
                    $dinasboppengumpuldata = DinasBopPengumpulDataTim::with('dinasboppengumpuldata')->find($_id);
                    $view = View::make('dinasbop.print_pengumpuldata.spd', ['timpengumpuldata'=>$dinasboppengumpuldata]);
                    break;
                case 'administrasi':
                    $dinasbopadministrasi = DinasBopAdministrasiTim::with('dinasbopadministrasi')->find($_id);
                    $view = View::make('dinasbop.print_administrasi.spd', ['timadministrasi'=>$dinasbopadministrasi]);
                    break;
                case 'custom':
                    $dinasbopcustom = DinasBopCustomTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_custom.spd', ['dinasbopcustom'=>$dinasbopcustom]);
                    break;
            }

            return $view;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_rbpd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            $view = '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_tim.rbpd', ['dinasboptim'=>$dinasboptim]);
                    break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_driver.rbpd', ['dinasbopdriver'=>$dinasbopdriver]);
                    break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_inspektur.rbpd', ['dinasbopinspektur'=>$dinasbopinspektur]);
                    break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekretaris::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_sekretaris.rbpd', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                    break;
                case 'reviu':
                    $dinasbopreviu = DinasBopReviu::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_reviu.rbpd', ['dinasbopreviu'=>$dinasbopreviu]);
                    break;
                case 'supervisi':
                    $dinasbopsupervisi = DinasBopSupervisi::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_supervisi.rbpd', ['dinasbopsupervisi'=>$dinasbopsupervisi]);
                    break;
                case 'pengumpuldata':
                    $dinasboppengumpuldata = DinasBopPengumpulDataTim::with('dinasboppengumpuldata')->find($_id);
                    $view = View::make('dinasbop.print_pengumpuldata.rbpd', ['timpengumpuldata'=>$dinasboppengumpuldata]);
                    break;
                case 'administrasi':
                    $dinasbopadministrasi = DinasBopAdministrasiTim::with('dinasbopadministrasi')->find($_id);
                    $view = View::make('dinasbop.print_administrasi.rbpd', ['timadministrasi'=>$dinasbopadministrasi]);
                    break;
                case 'custom':
                    $dinasbopcustom = DinasBopCustomTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_custom.rbpd', ['dinasbopcustom'=>$dinasbopcustom]);
                    break;
            }
            return $view;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_dpbo(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            $view = '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_tim.dpbo', ['dinasboptim'=>$dinasboptim]);
                    break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_driver.dpbo', ['dinasbopdriver'=>$dinasbopdriver]);
                    break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_inspektur.dpbo', ['dinasbopinspektur'=>$dinasbopinspektur]);
                    break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekretaris::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_sekretaris.dpbo', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                    break;
                case 'reviu':
                    $dinasbopreviu = DinasBopReviu::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_reviu.dpbo', ['dinasbopreviu'=>$dinasbopreviu]);
                    break;
                case 'supervisi':
                    $dinasbopsupervisi = DinasBopSupervisi::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_supervisi.dpbo', ['dinasbopsupervisi'=>$dinasbopsupervisi]);
                    break;
                case 'pengumpuldata':
                    $dinasboppengumpuldata = DinasBopPengumpulDataTim::with('dinasboppengumpuldata')->find($_id);
                    $view = View::make('dinasbop.print_pengumpuldata.dpbo', ['timpengumpuldata'=>$dinasboppengumpuldata]);
                    break;
                case 'administrasi':
                    $dinasbopadministrasi = DinasBopAdministrasiTim::with('dinasbopadministrasi')->find($_id);
                    $view = View::make('dinasbop.print_administrasi.dpbo', ['timadministrasi'=>$dinasbopadministrasi]);
                    break;
                case 'custom':
                    $dinasbopcustom = DinasBopCustomTim::with('dinasbop')->find($_id);
                    $view = View::make('dinasbop.print_custom.dpbo', ['dinasbopcustom'=>$dinasbopcustom]);
                    break;
            }
            return $view;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_personil_all(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasbop = DinasBop::with('tim')->find($_id);
            return View::make('dinasbop.print_tim.daftar_personil_all', ['dinasbop'=>$dinasbop]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_approval_data(Request $request)
    {
        $act = $request['act'];
        $type = $request['type'];
        $tab = $request['tab'];
        $dinasbop_id = $request['id'];

        if ($act == 'revision') {
            $approvalbop = DinasBopApproval::where('dinasbop_id', $dinasbop_id)->where('tab', $tab)->first();
            $column = $approvalbop[$type];
            array_push($column['catatan'], [
                'text'=>$request->input('catatan'),
                'date' => date('Y-m-d H:i:s')
            ]);

            $primary_id = $approvalbop['id'];

            $dinasboprevision = DinasBopApproval::find($primary_id);
            $dinasboprevision->{$type} = $column;
            $dinasboprevision->updated_at = date('Y-m-d H:i:s');

            if ($dinasboprevision->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }

        } else if ($act == 'approve') {
            $approvalbop = DinasBopApproval::where('dinasbop_id', $dinasbop_id)->where('tab', $tab)->first();
            $column = $approvalbop[$type];
            $column['approval'] = 1;
            $primary_id = $approvalbop['id'];

            $dinasbopapproval = DinasBopApproval::find($primary_id);
            $dinasbopapproval->{$type} = $column;
            $dinasbopapproval->updated_at = date('Y-m-d H:i:s');
            if ($dinasbopapproval->save()) {
                $dinasboplock = DinasBopApproval::find($primary_id);
                $i = 0;
                if ($dinasboplock->inspektur['approval'] == 1) {
                    $i++;
                }
                if ($dinasboplock->sekretaris['approval'] == 1) {
                    $i++;
                }
                if ($dinasboplock->kassubag['approval'] == 1) {
                    $i++;
                }

                if ($i == 3) {
                    $dinasboplock->lock = 1;
                    if ($dinasboplock->save()) {
                        $x = 0;
                        $dinasboplockall = DinasBopApproval::where('dinasbop_id', $dinasbop_id)->get();
                        foreach ($dinasboplockall as $y) {
                            if ($y->lock == 1) {
                                $x++;
                            }
                        }

                        if ($x >= 8) {
                            DinasBop::where('id', $dinasbop_id)->update(['status' => 1]);
                        }
                    }
                }

                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        }
    }

    public function put_lock_data(Request $request)
    {
        $dinasbop = DinasBop::find($request['id']);
        $dinasbop->status = 1;
        if ($dinasbop->save()) {
            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }
}
