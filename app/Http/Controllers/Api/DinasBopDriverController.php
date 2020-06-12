<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Common;
use App\Libraries\TimDinas;
use App\Libraries\KasAnggaran;
use App\Models\DinasBop;
use App\Models\DinasBopDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Exception;

class DinasBopDriverController extends Controller
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
      'driver' => $request->input('driver')
    ];
    
    $checktimdinasbop = $timdinas->check_driver_bop($parameter);
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
        $payload = [
          'page' => 'Dinas BOP - Pengemudi',
          'message' => 'User dengan NIP '.$request->query('nip').' menambahkan pengemudi baru pada Dinas BOP'
        ];
        $this->_common->generate_log($payload);
        
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
  
  public function put_data(Request $request)
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
      $payload = [
        'page' => 'Dinas BOP - Pengemudi',
        'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan data pengemudi pada Dinas BOP'
      ];
      $this->_common->generate_log($payload);
      
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
      $dinasbopdriver = DinasBopDriver::find($request['id']);
      $dinasbop_id = $dinasbopdriver->dinasbop_id;
      $anggaran = $dinasbopdriver->total;
      if ($dinasbopdriver->delete()) {
        $payload = [
          'page' => 'Dinas BOP - Pengemudi',
          'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pengemudi pada Dinas BOP'
        ];
        $this->_common->generate_log($payload);
        
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