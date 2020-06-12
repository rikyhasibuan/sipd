<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopInspektur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Exception;

class DinasBopInspekturController extends Controller
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
      'dinasbop'=> $request['dinasbop'],
      'dari'=> $request->input('dari'),
      'sampai' => $request->input('sampai'),
      'inspektur' => $request->input('inspektur')
    ];
    
    $check_inspektur_bop = $timdinas->check_inspektur_bop($parameter);
    if ($check_inspektur_bop == true) {
      $timdinasbop = $timdinas->generate_inspektur_bop($parameter);
      
      $dasar = array_values(array_filter($request->input('dasar')));
      $tujuan = array_values(array_filter($request->input('tujuan')));
      
      $dinasbopinspektur = new DinasBopInspektur();
      $dinasbopinspektur->dinasbop_id = $request['dinasbop'];
      $dinasbopinspektur->nomor_sp = $request->input('nomor_sp');
      $dinasbopinspektur->tgl_sp = $request->input('tgl_sp');
      $dinasbopinspektur->dari = $request->input('dari');
      $dinasbopinspektur->sampai = $request->input('sampai');
      $dinasbopinspektur->dasar = $dasar;
      $dinasbopinspektur->tujuan = $tujuan;
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
  
  public function put_data(Request $request)
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
  
  public function delete_data(Request $request)
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
        return response()->json(['status' => 'ok'], 200);
      } else {
        return response()->json(['status' => 'failed'], 500);
      }
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}