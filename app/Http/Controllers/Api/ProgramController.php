<?php

namespace App\Http\Controllers\Api;

use App\Models\Program;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
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
        $program = new Program();
        $program->kode_program = $request->input('kode_program');
        $program->nama_program = $request->input('nama_program');
        $program->created_at = date('Y-m-d H:i:s');
        if ($program->save()) {
            return response()->json(['status'=>'OK'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function put_data(Request $request)
    {
        $program = Program::find($request['id']);
        $program->kode_program = $request->input('kode_program');
        $program->nama_program = $request->input('nama_program');
        $program->updated_at = date('Y-m-d H:i:s');
        if ($program->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        $program = Program::find($request['id']);
        if ($program->delete()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
