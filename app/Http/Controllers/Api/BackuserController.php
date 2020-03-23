<?php

namespace App\Http\Controllers\Api;

use App\Models\Backuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackuserController extends Controller
{
    public function getData(Request $request)
    {
        try {
            $_query = isset($request['q']) ? $request['q'] : '';
            $_status = isset($request['status']) ?  $request['status'] : '';
            $_level = isset($request['level']) ?  $request['level'] : '';
            $user = Backuser::searchUser($_query)->searchLevel($_level)->searchStatus($_status)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postData(Request $request)
    {
        $backuser = new Backuser();
        $backuser->username = $request->input('username');
        $backuser->nama = $request->input('nama');
        $backuser->password = md5('mstc');
        $backuser->level = $request->input('level');
        $backuser->status = $request->input('status');
        $backuser->created_at = date('Y-m-d H:i:s');
        if ($backuser->save()) {
            return response()->json(['status'=>'OK'], 200);
        } else {
            return response()->json(['status'=>'FAILED'], 500);
        }
    }

    public function showData(Request $request)
    {
        return response()->json(Backuser::find($request['id']), 200);
    }

    public function putData(Request $request)
    {
        $backuser = Backuser::find($request['id']);
        $backuser->username = $request->input('username');
        $backuser->nama = $request->input('nama');
        $backuser->level = $request->input('level');
        $backuser->status = $request->input('status');
        $backuser->updated_at = date('Y-m-d H:i:s');
        if ($backuser->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'FAILED'], 500);
        }
    }

    public function deleteData(Request $request)
    {
        $backuser = Backuser::find($request['id']);
        if ($backuser->delete()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'FAILED'], 500);
        }
    }
}
