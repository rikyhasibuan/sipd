<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function putUpdatePassword(Request $request) {
        $backuser = User::find($request->input('id'));
        $backuser->password = md5($request->input('password'));
        $backuser->updated_at = date('Y-m-d H:i:s');
        if ($backuser->save()) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
