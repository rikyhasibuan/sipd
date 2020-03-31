<?php

namespace App\Http\Controllers\Api;

use App\Models\Bbm;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class BbmController extends Controller
{
    public function get_data()
    {
        try {
            $bbm = Bbm::with('kabkota')->orderBy('id', 'DESC')->get();
            return response()->json($bbm, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        try {
            return response()->json(Bbm::find($request['id']), 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function put_data(Request $request)
    {
        $bbm = Bbm::find($request['id']);
        $bbm->kabkota_id = $request->input('kabkota_id');
        $bbm->liter = $request->input('liter');
        $bbm->updated_at = date('Y-m-d H:i:s');
        if ($bbm->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
