<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IrbanPokja;
use Exception;

class PokjaController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function get_data(Request $request) {
        try {
            $_irban = isset($request['irban']) ? $request['irban'] : '';
            $_q = isset($request['q']) ? $request['q'] : '';
            $irban = IrbanPokja::with('irban', 'pegawai')->searchPegawai($_q)->searchIrban($_irban)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($irban, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_data(Request $request) {
        try {
            $check = IrbanPokja::where('irban_id', $request->input('irban_id'))
            ->where('pegawai_id', $request->input('pegawai_id'))->count();

            if ($check == 0) {
                $irbanpokja = new IrbanPokja();
                $irbanpokja->irban_id = $request->input('irban_id');
                $irbanpokja->pegawai_id = $request->input('pegawai_id');
                $irbanpokja->created_at = date('Y-m-d H:i:s');
                if ($irbanpokja->save()) {
                    $payload = [
                        'page' => 'Kelompok Kerja',
                        'message' => 'User dengan NIP '.$request->query('nip').' menambahkan data kelompok kerja baru'
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
            $check = IrbanPokja::where('irban_id', $request->input('irban_id'))
            ->where('pegawai_id', $request->input('pegawai_id'))
            ->where('id', '<>', $request['id'])->count();

            if ($check == 0) {
                $irbanpokja = IrbanPokja::find($request->input('id'));
                $irbanpokja->irban_id = $request->input('irban_id');
                $irbanpokja->pegawai_id = $request->input('pegawai_id');
                $irbanpokja->updated_at = date('Y-m-d H:i:s');
                if ($irbanpokja->save()) {
                    $payload = [
                        'page' => 'Kelompok Kerja',
                        'message' => 'User dengan NIP '.$request->query('nip').' melakukan perubahan pada data kelompok kerja'
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

    public function delete_data(Request $request) {
        try {
            $irbanpokja = IrbanPokja::find($request['id']);
            if ($irbanpokja->delete()) {
                $payload = [
                    'page' => 'Kelompok Kerja',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pada kelompok kerja'
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
