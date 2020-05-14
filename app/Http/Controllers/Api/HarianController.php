<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\Harian;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class HarianController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function get_data(Request $request)
    {
        try {
            $_kabkota = ($request['kabkota'] !== '') ? $request['kabkota'] : '';
            $harian = Harian::searchKabkota($_kabkota)->with('kabkota')->orderBy('id', 'DESC')->paginate(10);
            return response()->json($harian, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Harian::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        $harian = new Harian();
        $harian->kabkota_id = $request->input('kabkota_id');
        $harian->gol_1 = $request->input('gol_1');
        $harian->gol_2 = $request->input('gol_2');
        $harian->gol_3 = $request->input('gol_3');
        $harian->gol_4 = $request->input('gol_4');
        $harian->created_at = date('Y-m-d H:i:s');
        if ($harian->save()) {
            $payload = [
                'page' => 'Uang Harian',
                'message' => 'User dengan NIP '.$request['nip'].' menambahkan data uang harian baru'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_data(Request $request)
    {
        $harian = Harian::find($request['id']);
        $harian->kabkota_id = $request->input('kabkota_id');
        $harian->gol_1 = $request->input('gol_1');
        $harian->gol_2 = $request->input('gol_2');
        $harian->gol_3 = $request->input('gol_3');
        $harian->gol_4 = $request->input('gol_4');
        $harian->updated_at = date('Y-m-d H:i:s');
        if ($harian->save()) {
            $payload = [
                'page' => 'Uang Harian',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan perubahan pada data uang harian'
            ];
            $this->_common->generate_log($payload);

            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        $harian = Harian::find($request['id']);
        if ($harian->delete()) {
            $payload = [
                'page' => 'Uang Harian',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada uang harian'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
