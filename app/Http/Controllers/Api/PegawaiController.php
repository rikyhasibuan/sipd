<?php

namespace App\Http\Controllers\Api;

use App\Models\Pegawai;
use App\Libraries\Common;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{
    protected $common;

    public function __construct()
    {
        $this->common = new Common();
    }

    public function get_data(Request $request)
    {
        try {
            $_query = ($request['q'] !== '') ? $request['q'] : '';
            $_pangkat = ($request['pangkat'] !== '') ? $request['pangkat'] : '';
            $_golongan = ($request['golongan'] !== '') ? $this->common->join_golongan($request['golongan']) : '';
            $_jabatan = ($request['jabatan'] !== '') ? $request['jabatan'] : '';
            $_eselon = ($request['eselon'] !== '') ? $request['eselon'] : '';

            $pegawai = Pegawai::searchPegawai($_query)
                        ->searchPangkat($_pangkat)
                        ->searchGolongan($_golongan)
                        ->searchJabatan($_jabatan)
                        ->searchEselon($_eselon)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

            return response()->json($pegawai, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Pegawai::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        $check = Pegawai::where('nip', $request->input('nip'))->count();
        if ($check == 0) {
            $pegawai = new Pegawai();
            $pegawai->nip = $request->input('nip');
            $pegawai->nama = $request->input('nama');
            $pegawai->pangkat = $request->input('pangkat');
            $pegawai->golongan = $request->input('golongan');
            $pegawai->jabatan = $request->input('jabatan');
            $pegawai->eselon = $request->input('eselon');
            $pegawai->created_at = date('Y-m-d H:i:s');
            if ($pegawai->save()) {
                $payload = [
                    'page' => 'Pegawai',
                    'message' => 'User dengan NIP '.$request['nip'].' menambahkan data pegawai baru'
                ];
                $this->_common->generate_log($payload);
                return response()->json(['status'=>'ok'], 200);
            } else {
                return response()->json(['status'=>'failed'], 500);
            }
        } else {
            return response()->json(['status'=>'duplicate'], 200);
        }
    }

    public function put_data(Request $request)
    {
        $pegawai = Pegawai::find($request['id']);
        $pegawai->nip = $request->input('nip');
        $pegawai->nama = $request->input('nama');
        $pegawai->pangkat = $request->input('pangkat');
        $pegawai->golongan = $request->input('golongan');
        $pegawai->jabatan = $request->input('jabatan');
        $pegawai->eselon = $request->input('eselon');
        $pegawai->updated_at = date('Y-m-d H:i:s');
        if ($pegawai->save()) {
            $payload = [
                'page' => 'Pegawai',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan perubahan pada data pegawai'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        $pegawai = Pegawai::find($request['id']);
        if ($pegawai->delete()) {
            $payload = [
                'page' => 'Pegawai',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada pegawai'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
