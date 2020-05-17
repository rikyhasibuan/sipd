<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\Program;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramStoreRequest;

class ProgramController extends Controller
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
            $program = Program::searchProgram($_query)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($program, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(Program::find($request['id']), 200);
    }

    public function post_data(Request $request)
    {
        $check = Program::where(
                                [
                                    'kode_program'=> $request->input('kode_program'),
                                    'nama_program'=>$request->input('nama_program')
                                ]
                                )->count();
        if ($check == 0) {
            $program = new Program();
            $program->kode_program = $request->input('kode_program');
            $program->nama_program = $request->input('nama_program');
            $program->created_at = date('Y-m-d H:i:s');
            if ($program->save()) {
                $payload = [
                    'page' => 'Program',
                    'message' => 'User dengan NIP '.$request['nip'].' menambahkan data program baru'
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
        $program = Program::find($request['id']);
        $program->kode_program = $request->input('kode_program');
        $program->nama_program = $request->input('nama_program');
        $program->updated_at = date('Y-m-d H:i:s');
        if ($program->save()) {
            $payload = [
                'page' => 'Program',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan perubahan pada data program'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        try {
            $program = Program::find($request['id']);
            if ($program->delete()) {
                $payload = [
                    'page' => 'Program',
                    'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada program'
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
