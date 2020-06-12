<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Exception;

class DinasBopTimController extends Controller
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
      $payload = [
        'page' => 'Dinas BOP - Tim',
        'message' => 'User dengan NIP '.$request->query('nip').' menambahkan tim baru pada Dinas BOP'
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
      $payload = [
        'page' => 'Dinas BOP - Tim',
        'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan tim pada Dinas BOP'
      ];
      $this->_common->generate_log($payload);
      
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
      $dinasboptim = DinasBopTim::find($request['id']);
      $dinasbop_id = $dinasboptim->dinasbop_id;
      $anggaran_tim = $dinasboptim->total_anggaran;
      if ($dinasboptim->delete()) {
        $payload = [
          'page' => 'Dinas BOP - Tim',
          'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus tim pada Dinas BOP'
        ];
        $this->_common->generate_log($payload);
        
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