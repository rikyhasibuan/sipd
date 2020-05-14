<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Common;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $common;

    public function __construct()
    {
        $this->common = new Common();
    }

    public function get_data(Request $request)
    {
        try {
            $_query = isset($request['q']) ? $request['q'] : '';
            $_status = isset($request['status']) ?  $request['status'] : '';
            $_level = isset($request['level']) ?  $request['level'] : '';
            $user = User::searchNotAdmin()
                        ->searchUser($_query)
                        ->searchLevel($_level)
                        ->searchStatus($_status)
                        ->with('level','pegawai')
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_data(Request $request)
    {
        $user = new User();
        $user->nip = $request->input('nip');
        $user->password = md5('inspektorat');
        $user->level_id = $request->input('level_id');
        $user->status = $request->input('status');
        $user->created_at = date('Y-m-d H:i:s');
        if ($user->save()) {
            $payload = [
                'page' => 'User',
                'message' => 'User dengan NIP '.$request['nip'].' menambahkan data user baru'
            ];
            $this->_common->generate_log($payload);

            return response()->json(['status'=>'ok'], 200);
        } else {
            return response()->json(['status'=>'failed'], 500);
        }
    }

    public function show_data(Request $request)
    {
        return response()->json(User::find($request['id']), 200);
    }

    public function put_data(Request $request)
    {
        $user = User::find($request['id']);
        $user->nip = $request->input('nip');
        $user->level_id = $request->input('level_id');
        $user->status = $request->input('status');
        $user->updated_at = date('Y-m-d H:i:s');
        if ($user->save()) {
            $payload = [
                'page' => 'Program',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan perubahan pada data user'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function delete_data(Request $request)
    {
        $user = User::find($request['id']);
        if ($user->delete()) {
            $payload = [
                'page' => 'User',
                'message' => 'User dengan NIP '.$request['nip'].' melakukan hapus data pada user'
            ];
            $this->_common->generate_log($payload);
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
