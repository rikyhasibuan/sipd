<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    public function get_data(Request $request)
    {
        try {
            $_query = ($request['q'] !== '') ? $request['q'] : '';
            $_program = ($request['program'] !== '') ? $request['program'] : '';
            $_bendahara = ($request['bendahara'] !== '') ? $request['bendahara'] : '';

            $kegiatan = Kegiatan::searchKegiatan($_query)
                                ->searchProgram($_program)
                                ->searchBendahara($_bendahara)
                                ->with('program', 'pegawai')
                                ->orderBy('id', 'DESC')
                                ->paginate(10);

            return response()->json($kegiatan, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Kegiatan::find($request['id']), 200);
    }

    public function show_data_by_parent(Request $request)
    {
        return response()->json(Kegiatan::where('program_id', $request['program'])->get(), 200);
    }

    public function post_data(Request $request)
    {
        $check = Kegiatan::where(function ($query) use ($request) {
            $query->where('kode_kegiatan', $request->input('kode_kegiatan'))
            ->orWhere('nama_kegiatan', $request->input('nama_kegiatan'));
        })->count();
        
        if ($check == 0) {
            $kegiatan = new Kegiatan();
            $kegiatan->program_id = $request->input('program_id');
            $kegiatan->kode_kegiatan = $request->input('kode_kegiatan');
            $kegiatan->nama_kegiatan = $request->input('nama_kegiatan');
            $kegiatan->bendahara = $request->input('bendahara');
            $kegiatan->created_at = date('Y-m-d H:i:s');
            if ($kegiatan->save()) {
                $payload = [
                    'page' => 'Kegiatan',
                    'message' => 'User dengan NIP '.$request->query('nip').' menambahkan data kegiatan baru'
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
        $check = Kegiatan::where('id', '<>', $request['id'])
        ->where(function ($query) use ($request) {
            $query->where('kode_kegiatan', $request->input('kode_kegiatan'))
            ->orWhere('nama_kegiatan', $request->input('nama_kegiatan'));
        })->count();

        if($check === 0) {
            $kegiatan = Kegiatan::find($request['id']);
            $kegiatan->program_id = $request->input('program_id');
            $kegiatan->kode_kegiatan = $request->input('kode_kegiatan');
            $kegiatan->nama_kegiatan = $request->input('nama_kegiatan');
            $kegiatan->bendahara = $request->input('bendahara');
            $kegiatan->updated_at = date('Y-m-d H:i:s');
            if ($kegiatan->save()) {
                $payload = [
                    'page' => 'Kegiatan',
                    'message' => 'User dengan NIP ' . $request->query('nip') . ' melakukan perubahan pada data kegiatan'
                ];
                $this->_common->generate_log($payload);
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } else {
            return response()->json(['status' => 'duplicate'], 200);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $kegiatan = Kegiatan::find($request['id']);
            if ($kegiatan->delete()) {
                $payload = [
                    'page' => 'Kegiatan',
                    'message' => 'User dengan NIP '.$request->query('nip').' melakukan hapus data pada kegiatan'
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
