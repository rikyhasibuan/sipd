<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IrbanKabkota;
use Exception;

class IrbanKabkotaController extends Controller
{
    public function get_data(Request $request) {
        try {
            $_irban = isset($request['irban']) ? $request['irban'] : '';
            $_kabkota = isset($request['kabkota']) ? $request['kabkota'] : '';
            $irban = IrbanKabkota::with('irban', 'kabkota')->searchKabkota($_kabkota)->searchIrban($_irban)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($irban, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_data(Request $request) {
        try {
            $check = IrbanKabkota::where('kabkota_id', $request->input('kabkota_id'))->count();
            if ($check == 0) {
                $irbankabkota = new IrbanKabkota();
                $irbankabkota->irban_id = $request->input('irban_id');
                $irbankabkota->kabkota_id = $request->input('kabkota_id');
                $irbankabkota->created_at = date('Y-m-d H:i:s');
                if ($irbankabkota->save()) {
                    return response()->json(['status' => 'ok'], 200);
                } else {
                    return response()->json(['status' => 'failed'], 500);
                }
            } else {
                return response()->json(['status' => 'duplicate'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        try {
            $irbankabkota = IrbanKabkota::find($request->input('id'));
            $irbankabkota->irban_id = $request->input('irban_id');
            $irbankabkota->kabkota_id = $request->input('kabkota_id');
            $irbankabkota->updated_at = date('Y-m-d H:i:s');
            if ($irbankabkota->save()) {
                return response()->json(['status' => 'ok', 'irbankabkota' => $irbankabkota], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete_data(Request $request) {
        try {
            $irbankabkota = IrbanKabkota::find($request['id']);
            if ($irbankabkota->delete()) {
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /* public function exportData(Request $request) {
        try {
            $_irban = isset($request['irban']) ? $request['irban'] : '';
            $_skpd = isset($request['skpd']) ? $request['skpd'] : '';
            $data = IrbanSkpd::with('irban','skpd')->searchSkpd($_skpd)->searchIrban($_irban)->get();
            return Excel::create('Pembagian Wilayah Irban', function ($excel) use ($data) {
                $excel->sheet('Pembagian Wilayah Irban', function ($sheet) use ($data) {
                    $sheet->loadView('exports.irbanskpd', ['data' => $data]);
                });
            })->download('xls');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } */
}
