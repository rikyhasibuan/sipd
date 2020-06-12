<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopSekretaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Exception;

class DinasBopSekretarisController extends Controller
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
      'sekretaris' => $request->input('sekretaris')
    ];
    
    $check_sekretaris_bop = $timdinas->check_sekretaris_bop($parameter);
    if ($check_sekretaris_bop == true) {
      $timdinasbop = $timdinas->generate_sekretaris_bop($parameter);
      
      $dasar = array_values(array_filter($request->input('dasar')));
      $untuk = array_values(array_filter($request->input('tujuan')));
      
      $dinasbopsekretaris = new DinasBopSekretaris();
      $dinasbopsekretaris->dinasbop_id = $request['dinasbop'];
      $dinasbopsekretaris->nomor_sp = $request->input('nomor_sp');
      $dinasbopsekretaris->tgl_sp = $request->input('tgl_sp');
      $dinasbopsekretaris->dari = $request->input('dari');
      $dinasbopsekretaris->sampai = $request->input('sampai');
      $dinasbopsekretaris->dasar = $dasar;
      $dinasbopsekretaris->tujuan = $untuk;
      $dinasbopsekretaris->sekretaris = $timdinasbop['sekretaris'];
      $dinasbopsekretaris->total = $timdinasbop['total_anggaran'];
      $dinasbopsekretaris->created_at = date('Y-m-d H:i:s');
      
      if ($dinasbopsekretaris->save()) {
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
      'sekretaris' => $request->input('sekretaris')
    ];
    
    $timdinasbop = $timdinas->generate_sekretaris_bop($parameter);
    
    $dasar = array_values(array_filter($request->input('dasar')));
    $untuk = array_values(array_filter($request->input('tujuan')));
    
    $dinasbopsekretaris = DinasBopSekretaris::find($request['id']);
    
    $biaya_bop_lama = $dinasbopsekretaris->total;
    $dinasbopsekretaris->dinasbop_id = $request['dinasbop'];
    $dinasbopsekretaris->nomor_sp = $request->input('nomor_sp');
    $dinasbopsekretaris->tgl_sp = $request->input('tgl_sp');
    $dinasbopsekretaris->dari = $request->input('dari');
    $dinasbopsekretaris->sampai = $request->input('sampai');
    $dinasbopsekretaris->dasar = $dasar;
    $dinasbopsekretaris->tujuan = $untuk;
    $dinasbopsekretaris->sekretaris = $timdinasbop['sekretaris'];
    $dinasbopsekretaris->total = $timdinasbop['total_anggaran'];
    $dinasbopsekretaris->updated_at = date('Y-m-d H:i:s');
    
    if ($dinasbopsekretaris->save()) {
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
      $dinasbopsekretaris = DinasBopSekretaris::find($request['id']);
      $dinasbop_id = $dinasbopsekretaris->dinasbop_id;
      $anggaran = $dinasbopsekretaris->total;
      if ($dinasbopsekretaris->delete()) {
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