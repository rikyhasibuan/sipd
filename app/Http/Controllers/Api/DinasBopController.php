<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
        $dinasbop = new DinasBop();
        $dinasbop->program_id = $request->input('program_id');
        $dinasbop->kegiatan_id = $request->input('kegiatan_id');
        $dinasbop->belanja_id = $request->input('belanja_id');
        $dinasbop->dasar = $request->input('dasar');
        $dinasbop->untuk = $request->input('untuk');
        $dinasbop->dari = $request->input('dari');
        $dinasbop->sampai = $request->input('sampai');
        $dinasbop->created_at = date('Y-m-d H:i:s');
        if ($dinasbop->save()) {
            return response()->json(['status'=>'OK'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_data(Request $request)
    {
        $dinasbop = DinasBop::find($request['id']);
        $dinasbop->program_id = $request->input('program_id');
        $dinasbop->kegiatan_id = $request->input('kegiatan_id');
        $dinasbop->belanja_id = $request->input('belanja_id');
        $dinasbop->dasar = $request->input('dasar');
        $dinasbop->untuk = $request->input('untuk');
        $dinasbop->dari = $request->input('dari');
        $dinasbop->sampai = $request->input('sampai');
        $dinasbop->updated_at = date('Y-m-d H:i:s');
        if ($dinasbop->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
    
    public function delete_data(Request $request)
    {
        $anggaran = DinasBop::find($request['id']);
        $parent = $anggaran->id;
        if ($anggaran->delete()) {
            DinasBopTim::where('dinasbop_id', $parent)->delete();
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function show_tim_data(Request $request)
    {
        return response()->json(DinasBopTim::where('dinasbop_id', $request['dinasbop_id'])->get(), 200);
    }

    public function post_tim_data(Request $request)
    {
        $path = $request->file('lampiran')->store('lampiran_dinas/bop');
    
        $timdinas = new TimDinas();
        $parameter = [
                        'dinasbop' => $request['dinasbop'],
                        'auditan'=> $request->input('auditan'),
                        'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
                        'pengendaliteknis' => $request->input('pengendaliteknis'),
                        'ketuatim' => $request->input('ketuatim'),
                        'anggota' => json_decode($request->input('anggota'), true),
                        'driver' => $request->input('driver')
                    ];
        
        $timdinasbop = $timdinas->generate_tim_bop($parameter);
        $file = $request->file('lampiran');
        $file_name = $file->getClientOriginalName();
        $destination_path = 'public/lampiran/bop/';
        $request->file('lampiran')->move($destination_path, $file_name);

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
            $kasanggaran = new KasAnggaran();
            $biaya_bop = $kasanggaran->show_biaya_bop($request['dinasbop']);
            $dinasbop = DinasBop::find($request['dinasbop']);
            $dinasbop->total_anggaran = $biaya_bop + $timdinasbop['total_anggaran'];
            if ($dinasbop->save()) {
                return response()->json(['status'=>'OK'], 200);
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
                        'dinasbop'=>$request['dinasbop'],
                        'auditan'=> $request->input('auditan'),
                        'wakilpenanggungjawab' => $request->input('wakilpenanggungjawab'),
                        'pengendaliteknis' => $request->input('pengendaliteknis'),
                        'ketuatim' => $request->input('ketuatim'),
                        'anggota' => $request->input('anggota'),
                        'driver' => $request->input('driver')
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
        $dinasboptim->total_anggaran = $timdinasbop['total_anggaran'];
        $dinasboptim->updated_at = date('Y-m-d H:i:s');

        if ($dinasboptim->save()) {
            $kasanggaran = new KasAnggaran();
            $biaya_bop = $kasanggaran->show_biaya_bop($request['id']);
            $dinasbop = DinasBop::find($request['id']);
            $dinasbop->total_anggaran = $biaya_bop - $biaya_bop_lama + $timdinasbop['total_anggaran'];
            if ($dinasbop->save()) {
                return response()->json(['status'=>'OK'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_tim_data(Request $request)
    {
        $dinasboptim = DinasBopTim::find($request['id']);
        $dinasbop_id = $dinasboptim->dinasbop_id;
        $anggaran = $dinasboptim->total_anggaran;
        if ($dinasboptim->delete()) {
            $dinasbop = DinasBop::find($dinasbop_id);
            $total_anggaran = $dinasbop->total_anggaran;
            $dinasbop->total_anggaran = $total_anggaran - $anggaran;
            $dinasbop->save();
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
    
    public function get_print_sp(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
            return View::make('dinasbop.sp', ['dinasboptim'=>$dinasboptim]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_spd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
            return View::make('dinasbop.spd', ['dinasboptim'=>$dinasboptim]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_rbpd(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
            return View::make('dinasbop.rbpd', ['dinasboptim'=>$dinasboptim]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_personil(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
            return View::make('dinasbop.daftar_personil', ['dinasboptim'=>$dinasboptim]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_personil_all(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasbop = DinasBop::with('tim')->find($_id);
            return View::make('dinasbop.daftar_personil_all', ['dinasbop'=>$dinasbop]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_print_dpbo(Request $request)
    {
        try {
            $_id = isset($request['id']) ? $request['id'] : '';
            $dinasboptim = DinasBopTim::with('dinasbop')->find($_id);
            return View::make('dinasbop.dpbo', ['dinasboptim'=>$dinasboptim]);
        } catch (Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
