<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IrbanKabkota;
use Exception;

class IrbanKabkotaController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

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
                    $payload = [
                        'page' => 'Pembagian Wilayah Irban Menurut Kab/Kota',
                        'message' => 'User dengan NIP '.$request->query('nip').' menambahkan data pembagian wilayah irban baru'
                    ];
                    $this->_common->generate_log($payload);
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
                $payload = [
                    'page' => 'Pembagian Wilayah Irban Menurut Kab/Kota',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan pada data pembagian wilayah irban'
                ];
                $this->_common->generate_log($payload);
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
                $payload = [
                    'page' => 'Pembagian Wilayah Irban Menurut Kab/Kota',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pada pembagian wilayah irban'
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
