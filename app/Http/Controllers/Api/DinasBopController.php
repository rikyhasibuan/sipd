<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use App\Models\DinasBopDriver;
use App\Models\DinasBopInspektur;
use App\Models\DinasBopSekretaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Exception;

class DinasBopController extends Controller
{
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
            $dinasbop->created_at = date('Y-m-d H:i:s');
            if ($dinasbop->save()) {
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
        $dinasbop = DinasBop::find($request['id']);
        $dinasbop->program_id = $request->input('program_id');
        $dinasbop->kegiatan_id = $request->input('kegiatan_id');
        $dinasbop->belanja_id = $request->input('belanja_id');
        $dinasbop->dasar = $dasar;
        $dinasbop->untuk = $untuk;
        $dinasbop->dari = $request->input('dari');
        $dinasbop->sampai = $request->input('sampai');
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
            $anggaran = DinasBop::find($request['id']);
            $parent = $anggaran->id;
            if ($anggaran->delete()) {
                DinasBopTim::where('dinasbop_id', $parent)->delete();
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
        $path = $request->file('lampiran')->store('public/lampiran_dinas/bop');

        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop' => $request['dinasbop'],
                        'auditan'=> $request->input('auditan'),
                        'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
                        'pengendaliteknis' => $request->input('pengendaliteknis'),
                        'ketuatim' => $request->input('ketuatim'),
                        'anggota' => json_decode($request->input('anggota'), true),
                        'act' => 'create'
                    ];

        $timdinasbop = $timdinas->generate_tim_bop($parameter);
        $dinasboptim = new DinasBopTim();
        $dinasboptim->dinasbop_id = $request['dinasbop'];
        $dinasboptim->irban_id = $request->input('irban_id');
        $dinasboptim->auditan = $request->input('auditan');
        $dinasboptim->nomor_sp = $request->input('nomor_sp');
        $dinasboptim->tgl_sp = $request->input('tgl_sp');
        $dinasboptim->tim = $timdinasbop['tim'];
        $dinasboptim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptim->lampiran = $path;
        $dinasboptim->created_at = date('Y-m-d H:i:s');
        if ($dinasboptim->save()) {
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

    public function put_tim_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop'=>$request['id'],
                        'auditan'=> $request->input('auditan'),
                        'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
                        'pengendaliteknis' => $request->input('pengendaliteknis'),
                        'ketuatim' => $request->input('ketuatim'),
                        'anggota' => json_decode($request->input('anggota'), true),
                        'act' => 'put'
                    ];

        $timdinasbop = $timdinas->generate_tim_bop($parameter);

        $dinasboptim = DinasBopTim::find($request['id']);
        $biaya_bop_lama = $dinasboptim->total_anggaran;

        $dinasboptim->dinasbop_id = $request['dinasbop'];
        $dinasboptim->irban_id = $request->input('irban_id');
        $dinasboptim->auditan = $request->input('auditan');
        $dinasboptim->nomor_sp = $request->input('nomor_sp');
        $dinasboptim->tgl_sp = $request->input('tgl_sp');
        $dinasboptim->tim = $timdinasbop['tim'];

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('public/lampiran_dinas/bop');
            $dinasboptim->lampiran = $path;
        }

        $dinasboptim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptim->updated_at = date('Y-m-d H:i:s');

        if ($dinasboptim->save()) {
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

    public function delete_tim_data(Request $request)
    {
        try {
            $dinasboptim = DinasBopTim::find($request['id']);
            $dinasbop_id = $dinasboptim->dinasbop_id;
            $anggaran_tim = $dinasboptim->total_anggaran;
            //Storage::delete($dinasboptim->lampiran);
            if ($dinasboptim->delete()) {
                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = intval($total_anggaran) - intval($anggaran_tim);
                $dinasbop->save();
                return response()->json(['status' => 'OK'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_driver_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'dinasbop'=> $request['dinasbop'],
            'dari'=> $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'driver' => $request->input('driver')
        ];

        $checktimdinasbop = $timdinasbop->check_driver_bop($parameter);
        if ($checktimdinasbop == true) {
            $timdinasbop = $timdinas->generate_driver_bop($parameter);

            $dinasbopdriver = new DinasBopDriver();
            $dinasbopdriver->dinasbop_id = $request['dinasbop'];
            $dinasbopdriver->nomor_sp = $request->input('nomor_sp');
            $dinasbopdriver->tgl_sp = $request->input('tgl_sp');
            $dinasbopdriver->dari = $request->input('dari');
            $dinasbopdriver->sampai = $request->input('sampai');
            $dinasbopdriver->dasar = $request->input('dasar');
            $dinasbopdriver->tujuan = $request->input('tujuan');
            $dinasbopdriver->driver = $timdinasbop['driver'];
            $dinasbopdriver->total = $timdinasbop['total_anggaran'];
            $dinasbopdriver->created_at = date('Y-m-d H:i:s');

            if ($dinasbopdriver->save()) {
                $dinasbop = DinasBop::find($request['dinasbop']);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = intval($total_anggaran) + intval($timdinasbop['total_anggaran']);
                $dinasbop->save();
                if ($dinasbop->save()) {
                    return response()->json(['status'=>'ok'], 200);
                } else {
                    return response()->json(['status'=>'failed'], 500);
                }
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'duplicate'], 200);
        }
    }

    public function put_driver_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'dari'=> $request->input('dari'),
                        'sampai' => $request->input('sampai'),
                        'driver' => $request->input('driver')
                    ];

        $timdinasbop = $timdinas->generate_driver_bop($parameter);

        $dinasbopdriver = DinasBopDriver::find($request['id']);
        $biaya_bop_lama = $dinasbopdriver->total;

        $dasar = array_values(array_filter($request->input('dasar')));
        $tujuan = array_values(array_filter($request->input('tujuan')));

        $dinasbopdriver->dinasbop_id = $request['dinasbop'];
        $dinasbopdriver->nomor_sp = $request->input('nomor_sp');
        $dinasbopdriver->tgl_sp = $request->input('tgl_sp');
        $dinasbopdriver->dari = $request->input('dari');
        $dinasbopdriver->sampai = $request->input('sampai');
        $dinasbopdriver->dasar = $dasar;
        $dinasbopdriver->tujuan = $tujuan;
        $dinasbopdriver->driver = $timdinasbop['driver'];
        $dinasbopdriver->total = $timdinasbop['total_anggaran'];
        $dinasbopdriver->updated_at = date('Y-m-d H:i:s');
        if ($dinasbopdriver->save()) {
            $dinasbop = DinasBop::find($request['dinasbop']);
            $biaya_bop = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $biaya_bop - $biaya_bop_lama + $timdinasbop['total_anggaran'];
            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_driver_data(Request $request)
    {
        try {
            $dinasbopdriver = DinasBopDriver::find($request['id']);
            $dinasbop_id = $dinasbopdriver->dinasbop_id;
            $anggaran = $dinasbopdriver->total;
            if ($dinasbopdriver->delete()) {
                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $total_anggaran - $anggaran;
                $dinasbop->save();
                return response()->json(['status' => 'OK'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_inspektur_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
            'dinasbop'=> $request['dinasbop'],
            'dari'=> $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'inspektur' => $request->input('inspektur')
        ];

        $check_inspektur_bop = $timdinas->check_inspektur_bop($parameter);
        if ($check_inspektur_bop == true) {
            $timdinasbop = $timdinas->generate_inspektur_bop($parameter);

            $dasar = array_values(array_filter($request->input('dasar')));
            $untuk = array_values(array_filter($request->input('tujuan')));

            $dinasbopinspektur = new DinasBopInspektur();
            $dinasbopinspektur->dinasbop_id = $request['dinasbop'];
            $dinasbopinspektur->nomor_sp = $request->input('nomor_sp');
            $dinasbopinspektur->tgl_sp = $request->input('tgl_sp');
            $dinasbopinspektur->dari = $request->input('dari');
            $dinasbopinspektur->sampai = $request->input('sampai');
            $dinasbopinspektur->dasar = $dasar;
            $dinasbopinspektur->tujuan = $untuk;
            $dinasbopinspektur->inspektur = $timdinasbop['inspektur'];
            $dinasbopinspektur->total = $timdinasbop['total_anggaran'];
            $dinasbopinspektur->created_at = date('Y-m-d H:i:s');
            if ($dinasbopinspektur->save()) {
                $dinasbop = DinasBop::find($request['dinasbop']);
                $biaya_bop = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $biaya_bop + $timdinasbop['total_anggaran'];
                if ($dinasbop->save()) {
                    return response()->json(['status'=>'ok'], 200);
                } else {
                    return response()->json(['status'=>'failed'], 500);
                }
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'duplicate'], 200);
        }
    }

    public function put_inspektur_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop'=> $request['dinasbop'],
                        'dari'=> $request->input('dari'),
                        'sampai' => $request->input('sampai'),
                        'inspektur' => $request->input('inspektur')
                    ];

        $timdinasbop = $timdinas->generate_inspektur_bop($parameter);

        $dasar = array_values(array_filter($request->input('dasar')));
        $untuk = array_values(array_filter($request->input('tujuan')));

        $dinasbopinspektur = DinasBopInspektur::find($request['id']);

        $biaya_bop_lama = $dinasbopinspektur->total;
        $dinasbopinspektur->dinasbop_id = $request['dinasbop'];
        $dinasbopinspektur->nomor_sp = $request->input('nomor_sp');
        $dinasbopinspektur->tgl_sp = $request->input('tgl_sp');
        $dinasbopinspektur->dari = $request->input('dari');
        $dinasbopinspektur->sampai = $request->input('sampai');
        $dinasbopinspektur->dasar = $dasar;
        $dinasbopinspektur->tujuan = $untuk;
        $dinasbopinspektur->inspektur = $timdinasbop['inspektur'];
        $dinasbopinspektur->total = $timdinasbop['total_anggaran'];
        $dinasbopinspektur->updated_at = date('Y-m-d H:i:s');
        if ($dinasbopinspektur->save()) {
            $dinasbop = DinasBop::find($request['dinasbop']);
            $biaya_bop = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $biaya_bop - $biaya_bop_lama + $timdinasbop['total_anggaran'];
            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_inspektur_data(Request $request)
    {
        try {
            $dinasbopinspektur = DinasBopInspektur::find($request['id']);
            $dinasbop_id = $dinasbopinspektur->dinasbop_id;
            $anggaran = $dinasbopinspektur->total;
            if ($dinasbopinspektur->delete()) {
                $dinasbop = DinasBop::find($dinasbop_id);
                $total_anggaran = $dinasbop->total_anggaran;
                $dinasbop->total_anggaran = $total_anggaran - $anggaran;
                $dinasbop->save();
                return response()->json(['status' => 'OK'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_sekretaris_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop'=> $request['dinasbop'],
                        'dari'=> $request->input('dari'),
                        'sampai' => $request->input('sampai'),
                        'sekretaris' => $request->input('sekretaris')
                    ];

        $timdinasbop = $timdinas->generate_sekretaris_bop($parameter);

        $dinasbopsekretaris = new DinasBopSekretaris();
        $dinasbopsekretaris->dinasbop_id = $request['dinasbop'];
        $dinasbopsekretaris->nomor_sp = $request->input('nomor_sp');
        $dinasbopsekretaris->tgl_sp = $request->input('tgl_sp');
        $dinasbopsekretaris->dari = $request->input('dari');
        $dinasbopsekretaris->sampai = $request->input('sampai');
        $dinasbopsekretaris->dasar = $request->input('dasar');
        $dinasbopsekretaris->tujuan = $request->input('tujuan');
        $dinasbopsekretaris->sekretaris = $timdinasbop['sekretaris'];
        $dinasbopsekretaris->total = $timdinasbop['total_anggaran'];
        $dinasbopsekretaris->created_at = date('Y-m-d H:i:s');
        if ($dinasbopsekretaris->save()) {
            $kasanggaran = new KasAnggaran();
            $biaya_bop = $kasanggaran->show_biaya_bop($request['dinasbop']);
            $dinasbop = DinasBop::find($request['dinasbop']);
            $dinasbop->total_anggaran = $biaya_bop + $timdinasbop['total_anggaran'];
            if ($dinasbop->save()) {
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_sekretaris_data(Request $request)
    {
        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop'=> $request['dinasbop'],
                        'dari'=> $request->input('dari'),
                        'sampai' => $request->input('sampai'),
                        'sekretaris' => $request->input('sekretaris')
                    ];

        $timdinasbop = $timdinas->generate_sekretaris_bop($parameter);

        $dinasbopsekretaris = DinasBopSekretaris::find($request['id']);

        $dinasbopsekretaris->dinasbop_id = $request['dinasbop'];
        $dinasbopsekretaris->nomor_sp = $request->input('nomor_sp');
        $dinasbopsekretaris->tgl_sp = $request->input('tgl_sp');
        $dinasbopsekretaris->dari = $request->input('dari');
        $dinasbopsekretaris->sampai = $request->input('sampai');
        $dinasbopsekretaris->dasar = $request->input('dasar');
        $dinasbopsekretaris->tujuan = $request->input('tujuan');
        $dinasbopsekretaris->sekretaris = $timdinasbop['sekretaris'];
        $dinasbopsekretaris->total = $timdinasbop['total_anggaran'];
        $dinasbopsekretaris->updated_at = date('Y-m-d H:i:s');
        if ($dinasbopsekretaris->save()) {
            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function get_print_sp(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_tim.sp', ['dinasboptim'=>$dinasboptim]);
                break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_driver.sp', ['dinasbopdriver'=>$dinasbopdriver]);
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_inspektur.sp', ['dinasbopinspektur'=>$dinasbopinspektur]);
                break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekeretaris::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_sekretaris.sp', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                break;
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_spd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_tim.spd', ['dinasboptim'=>$dinasboptim]);
                break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_driver.spd', ['dinasbopdriver'=>$dinasbopdriver]);
                break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_inspektur.spd', ['dinasbopinspektur'=>$dinasbopinspektur]);
                break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekeretaris::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_sekretaris.spd', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                break;
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_rbpd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_tim.rbpd', ['dinasboptim'=>$dinasboptim]);
                break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_driver.rbpd', ['dinasbopdriver'=>$dinasbopdriver]);
                break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_inspektur.rbpd', ['dinasbopinspektur'=>$dinasbopinspektur]);
                break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekeretaris::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_sekretaris.rbpd', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                break;
            }
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

    public function get_print_dpbo(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $_type = isset($request['type']) ? $request['type'] : '';
            switch ($_type) {
                case 'tim':
                    $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_tim.dpbo', ['dinasboptim'=>$dinasboptim]);
                break;
                case 'driver':
                    $dinasbopdriver = DinasBopDriver::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_driver.dpbo', ['dinasbopdriver'=>$dinasbopdriver]);
                break;
                case 'inspektur':
                    $dinasbopinspektur = DinasBopInspektur::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_inspektur.dpbo', ['dinasbopinspektur'=>$dinasbopinspektur]);
                break;
                case 'sekretaris':
                    $dinasbopsekretaris = DinasBopSekeretaris::with('dinasbop')->find($_id);
                    return View::make('dinasbop.print_sekretaris.dpbo', ['dinasbopsekretaris'=>$dinasbopsekretaris]);
                break;
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
