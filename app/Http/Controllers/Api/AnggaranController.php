<?php

namespace App\Http\Controllers\Api;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class AnggaranController extends Controller
{
    public function get_data(Request $request)
    {
        try {
            $_bulan = ($request['bulan'] !== '') ? $request['bulan'] : '';
            $_tahun = ($request['tahun'] !== '') ? $request['tahun'] : '';
            $_program = ($request['program'] !== '') ? $request['program'] : '';
            $_kegiatan = ($request['kegiatan'] !== '') ? $request['kegiatan'] : '';
            $_belanja = ($request['belanja'] !== '') ? $request['belanja'] : '';

            $anggaran = Anggaran::searchBulan($_bulan)
                                ->searchTahun($_tahun)
                                ->searchKegiatan($_kegiatan)
                                ->searchProgram($_program)
                                ->searchBelanja($_belanja)
                                ->with('program', 'kegiatan', 'belanja')
                                ->orderBy('id', 'DESC')->paginate(10);

            return response()->json($anggaran, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Anggaran::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        $check = Anggaran::searchBulan($request->input('bulan'))
                        ->searchTahun($request->input('tahun'))
                        ->searchKegiatan($request->input('kegiatan_id'))
                        ->searchProgram($request->input('program_id'))
                        ->searchBelanja($request->input('belanja_id'))
                        ->count();

        if ($check == 0) {
            $anggaran = new Anggaran();
            $anggaran->program_id = $request->input('program_id');
            $anggaran->kegiatan_id = $request->input('kegiatan_id');
            $anggaran->belanja_id = $request->input('belanja_id');
            $anggaran->jumlah = $request->input('jumlah');
            $anggaran->bulan = $request->input('bulan');
            $anggaran->tahun = $request->input('tahun');
            $anggaran->created_at = date('Y-m-d H:i:s');
            if ($anggaran->save()) {
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
        $anggaran = Anggaran::find($request['id']);
        $anggaran->program_id = $request->input('program_id');
        $anggaran->kegiatan_id = $request->input('kegiatan_id');
        $anggaran->belanja_id = $request->input('belanja_id');
        $anggaran->jumlah = $request->input('jumlah');
        $anggaran->bulan = $request->input('bulan');
        $anggaran->tahun = $request->input('tahun');
        $anggaran->updated_at = date('Y-m-d H:i:s');
        if ($anggaran->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $anggaran = Anggaran::find($request['id']);
            if ($anggaran->delete()) {
                return response()->json(['status' => 'ok'], 200);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
