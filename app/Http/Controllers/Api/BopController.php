<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\Bop;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class BopController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function get_data()
    {
        try {
            $bop = Bop::all();
            return response()->json(['data'=>$bop,'total'=>count($bop)], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Bop::find($request['id']), 200);
    }

    public function put_data(Request $request)
    {
        try {
            $bop = Bop::find($request['id']);
            $bop->jabatan = $request->input('jabatan');
            $bop->biaya_per_hari = $request->input('biaya_per_hari');
            $bop->updated_at = date('Y-m-d H:i:s');
            if ($bop->save()) {
                $payload = [
                    'page' => 'BOP',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan pada data Besaran BOP'
                ];
                $this->_common->generate_log($payload);
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
