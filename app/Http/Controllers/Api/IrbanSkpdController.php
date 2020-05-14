<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IrbanSkpd;
use Exception;

class IrbanSkpdController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

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
                    $payload = [
                        'page' => 'Pembagian Wilayah Irban Menurut Perangkat Daerah',
                        'message' => 'User dengan NIP '.$request['nip'].' menambahkan data pembagian wilayah irban baru'
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
            $irbanskpd = IrbanSkpd::find($request->input('id'));
            $irbanskpd->irban_id = $request->input('irban_id');
            $irbanskpd->skpd_id = $request->input('skpd_id');
            $irbanskpd->updated_at = date('Y-m-d H:i:s');
            if ($irbanskpd->save()) {
                $payload = [
                    'page' => 'Pembagian Wilayah Irban Menurut Perangkat Daerah',
                    'message' => 'User dengan NIP '.$request['nip'].' melakukan perubahan pada data pembagian wilayah irban'
                ];
                $this->_common->generate_log($payload);
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
                $payload = [
                    'page' => 'Pembagian Wilayah Irban Menurut Perangkat Daerah',
                    'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada pembagian wilayah irban'
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
