<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
        $user_data = array();
        $user_data['nip'] = $request->input('nip');
        $user_data['password'] = hash('md5', $request->input('password'));
        $user = User::where($user_data)->first();

        if ($user) {
            $response = array();
            $response['login'] = 'true';
            $response['id'] = $user['id'];
            $response['nip'] = $user['nip'];
            $response['level'] = $user['level_id'];
            $response['pegawai'] = [];
            return response()->json($response, 200);
        } else {
            return response()->json(['login' => 'false'], 200);
        }
    }
}
