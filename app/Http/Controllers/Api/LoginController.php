<?php

namespace App\Http\Controllers\Api;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
        try {
            $user_data = array();
            $user_data['nip'] = $request->input('nip');
            $user_data['password'] = hash('md5', $request->input('password'));
            $user = User::where($user_data)->first();

            if ($user) {
                if ($user['status'] == 1) {
                    $response = array();
                    $response['login'] = 'true';
                    $response['id'] = $user['id'];
                    $response['nip'] = $user['nip'];
                    $response['level'] = $user['level_id'];
                    if ($user['level_id'] != 1) {
                        $pegawai = Pegawai::where('nip', $user['nip'])->first();
                        $response['jabatan'] = $pegawai['jabatan'];
                    } else {
                        $response['jabatan'] = 'Administrator';
                    }
                    return response()->json($response, 200);
                } else {
                    return response()->json(['login' => 'inactive'], 200);
                }
            } else {
                return response()->json(['login' => 'false'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
