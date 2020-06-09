<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\Belanja;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class BelanjaController extends Controller
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
            $_kegiatan = ($request['kegiatan'] !== '') ? $request['kegiatan'] : '';

            $belanja = Belanja::searchBelanja($_query)
                            ->searchProgram($_program)
                            ->searchKegiatan($_kegiatan)
                            ->with('program', 'kegiatan')
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
            return response()->json($belanja, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Belanja::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        try {
            $check = Belanja::where(function ($query) use ($request) {
                $query->where('kode_belanja', $request->input('kode_belanja'))
                ->orWhere('nama_belanja', $request->input('nama_belanja'));
            })
            ->where(function ($query) use ($request) {
                $query->where('program_id', $request->input('program_id'))
                ->where('kegiatan_id', $request->input('kegiatan_id'));
            })->count();

            if ($check == 0) {
                $belanja = new Belanja();
                $belanja->program_id = $request->input('program_id');
                $belanja->kegiatan_id = $request->input('kegiatan_id');
                $belanja->kode_belanja = $request->input('kode_belanja');
                $belanja->nama_belanja = $request->input('nama_belanja');
                $belanja->created_at = date('Y-m-d H:i:s');
                if ($belanja->save()) {
                    $payload = [
                        'page' => 'Belanja',
                        'message' => 'User dengan NIP '.$request['nip'].' menambahkan data belanja baru'
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
            $check = Belanja::where('id', '<>', $request['id'])
            ->where(function ($query) use ($request) {
                $query->where('kode_belanja', $request->input('kode_belanja'))
                ->orWhere('nama_belanja', $request->input('nama_belanja'));
            })
            ->where(function ($query) use ($request) {
                $query->where('program_id', $request->input('program_id'))
                ->where('kegiatan_id', $request->input('kegiatan_id'));
            })->count();

            if ($check == 0) {
                $belanja = Belanja::find($request->input('id'));
                $belanja->program_id = $request->input('program_id');
                $belanja->kegiatan_id = $request->input('kegiatan_id');
                $belanja->kode_belanja = $request->input('kode_belanja');
                $belanja->nama_belanja = $request->input('nama_belanja');
                $belanja->updated_at = date('Y-m-d H:i:s');
                if ($belanja->save()) {
                    $payload = [
                        'page' => 'Belanja',
                        'message' => 'User dengan NIP ' . $request->query('nip') . ' melakukan perubahan pada data belanja'
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

    public function delete_data(Request $request)
    {
        try {
            $belanja = Belanja::find($request['id']);
            if ($belanja->delete()) {
                $payload = [
                    'page' => 'BBM',
                    'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada belanja'
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
