<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IrbanSkpd;
use Exception;

class IrbanSkpdController extends Controller
{
    public function get_data(Request $request) {
        try {
            $_irban = isset($request['irban']) ? $request['irban'] : '';
            $_skpd = isset($request['skpd']) ? $request['skpd'] : '';
            $irban = IrbanSkpd::with('irban', 'skpd')->searchSkpd($_skpd)->searchIrban($_irban)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($irban, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_data(Request $request) {
        try {
            $check = IrbanSkpd::where('skpd_id', $request->input('skpd'))->count();
            if ($check == 0) {
                $irbanskpd = new IrbanSkpd();
                $irbanskpd->irban_id = $request->input('irban_id');
                $irbanskpd->skpd_id = $request->input('skpd_id');
                $irbanskpd->created_at = date('Y-m-d H:i:s');
                if ($irbanskpd->save()) {
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
            $irbanskpd = IrbanSkpd::find($request->input('id'));
            $irbanskpd->irban_id = $request->input('irban_id');
            $irbanskpd->skpd_id = $request->input('skpd_id');
            $irbanskpd->updated_at = date('Y-m-d H:i:s');
            if ($irbanskpd->save()) {
                return response()->json(['status' => 'ok', 'irbanskpd' => $irbanskpd], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete_data(Request $request) {
        try {
            $irbanskpd = IrbanSkpd::find($request['id']);
            if ($irbanskpd->delete()) {
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
