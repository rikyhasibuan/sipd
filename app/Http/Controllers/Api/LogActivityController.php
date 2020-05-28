<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogAktifitas;
use Exception;

class LogActivityController extends Controller
{
  public function get_data(Request $request) {
    try {
      $start_date = ($request['start'] !== '' && $request['start'] !== 'null') ? $request['start'] : '';
      $end_date = ($request['end'] !== '' && $request['end'] !== 'null') ? $request['end'] : '';
      $log = LogAktifitas::searchAwalPeriode($start_date)->searchAkhirPeriode($end_date)->orderBy('id', 'DESC')->paginate(30);
      return response()->json($log, 200);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}