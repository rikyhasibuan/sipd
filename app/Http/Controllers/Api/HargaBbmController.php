<?php

namespace App\Http\Controllers\Api;

use App\Models\HargaBbm;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class HargaBbmController extends Controller
{

    public function show_data()
    {
        try {
            return response()->json(HargaBbm::find(1), 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        try {
            $hargabbm = HargaBbm::find($request['id']);
            $hargabbm->harga_perliter = $request->input('harga_perliter');
            $hargabbm->updated_at = date('Y-m-d H:i:s');
            if ($hargabbm->save()) {
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
