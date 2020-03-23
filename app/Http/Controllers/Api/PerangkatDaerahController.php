<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Skpd;
use Exception;

class PerangkatDaerahController extends Controller
{
    public function get_data(Request $request)
    {
        try {
            $q = isset($request['query']) ? $request['query'] : '';
            $skpd = Skpd::searchName($q)->orderBy('id', 'DESC')->paginate(10);
            return response()->json($skpd, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function post_data(Request $request)
    {
        try {
            $check_data = Skpd::where('nama_skpd', $request->input('nama_skpd'))->count();
            if ($check_data == 0) {
                $skpd = new Skpd();
                $skpd->nama_skpd = $request->input('nama_skpd');
                $skpd->alamat = $request->input('alamat');
                $skpd->kontak = $request->input('kontak');
                $skpd->kota = $request->input('kota');
                $skpd->created_at = date('Y-m-d H:i:s');
                if ($skpd->save()) {
                    return response()->json(['status' => 'OK'], 200);
                } else {
                    return response()->json(['status' => 'FAILED'], 500);
                }
            } else {
                return response()->json(['status' => 'DUPLICATE'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function putData(Request $request)
    {
        try {
            $skpd = Skpd::find($request->input('id'));
            $skpd->nama_skpd = $request->input('nama_skpd');
            $skpd->alamat = $request->input('alamat');
            $skpd->kontak = $request->input('kontak');
            $skpd->kota = $request->input('kota');
            $skpd->updated_at = date('Y-m-d H:i:s');
            if ($skpd->save()) {
                return response()->json(['status' => 'OK', 'skpd' => $skpd], 200);
            } else {
                return response()->json(['status' => 'FAILED'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteData(Request $request)
    {
        try {
            $skpd = Skpd::find($request['id']);
            if ($skpd->delete()) {
                return response()->json(['status' => 'OK'], 200);
            } else {
                return response()->json(['status' => 'FAILED'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
