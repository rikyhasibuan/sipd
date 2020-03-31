<?php

namespace App\Http\Controllers\Api;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
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
        $check = Kegiatan::where(
                                    [
                                        'program_id' => $request->input('program_id'),
                                        'kode_kegiatan' => $request->input('kode_kegiatan'),
                                        'nama_kegiatan' => $request->input('nama_kegiatan'),
                                        'bendahara' => $request->input('bendahara'),
                                    ]
                                )->count();
        if ($check == 0) {
            $kegiatan = new Kegiatan();
            $kegiatan->program_id = $request->input('program_id');
            $kegiatan->kode_kegiatan = $request->input('kode_kegiatan');
            $kegiatan->nama_kegiatan = $request->input('nama_kegiatan');
            $kegiatan->bendahara = $request->input('bendahara');
            $kegiatan->created_at = date('Y-m-d H:i:s');
            if ($kegiatan->save()) {
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
        $kegiatan = Kegiatan::find($request['id']);
        $kegiatan->program_id = $request->input('program_id');
        $kegiatan->kode_kegiatan = $request->input('kode_kegiatan');
        $kegiatan->nama_kegiatan = $request->input('nama_kegiatan');
        $kegiatan->bendahara = $request->input('bendahara');
        $kegiatan->updated_at = date('Y-m-d H:i:s');
        if ($kegiatan->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $kegiatan = Kegiatan::find($request['id']);
            if ($kegiatan->delete()) {
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
