<?php

namespace App\Http\Controllers\Api;

use App\Models\Backuser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function putUpdatePassword(Request $request) {
        $backuser = Backuser::find($request->input('id'));
        $backuser->password = md5($request->input('password'));
        $backuser->updated_at = date('Y-m-d H:i:s');
        if ($backuser->save()) {
            return response()->json(['status' => 'OK'], 200);
        } else {
            return response()->json(['status' => 'FAILED'], 500);
        }
    }
}
