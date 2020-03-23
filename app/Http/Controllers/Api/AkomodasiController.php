<?php

namespace App\Http\Controllers\Api;

use App\Models\Akomodasi;
use App\Models\Harian;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class AkomodasiController extends Controller
{
    public function get_data(Request $request)
    {
        try {
            $_kabkota = ($request['kabkota'] !== '') ? $request['kabkota'] : '';
            $akomodasi = Akomodasi::searchKabkota($_kabkota)->with('kabkota')->orderBy('id', 'DESC')->paginate(10);
            return response()->json($akomodasi, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        try {
            return response()->json(Harian::find($request['id']), 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        $akomodasi = Akomodasi::find($request['id']);
        $akomodasi->kabkota_id = $request->input('kabkota_id');
        $akomodasi->eselon_2 = $request->input('eselon_2');
        $akomodasi->eselon_3 = $request->input('eselon_3');
        $akomodasi->eselon_4_gol_3_4 = $request->input('eselon_4_gol_3_4');
        $akomodasi->madya = $request->input('madya');
        $akomodasi->gol_1_2 = $request->input('gol_1_2');
        $akomodasi->updated_at = date('Y-m-d H:i:s');
        if ($akomodasi->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
