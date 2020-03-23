<?php

namespace App\Http\Controllers\Api;

use App\Models\DinasRegular;
use App\Models\DinasBop;
use App\Models\DinasRegularTim;
use App\Models\DinasBopTim;
use App\Models\Anggaran;
use App\Libraries\KasAnggaran;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getData()
    {
        try {
            $kas = new KasAnggaran();
            $year = date('Y');
            $sql_anggaran = Anggaran::with('belanja')->where('tahun', $year)->get();
            $resapan_anggaran = 0;
            $resapan1   = [];
            $anggaran1  = [];
            $resapan2   = [];
            $anggaran2  = [];
            $resapan3   = [];
            $anggaran3  = [];
            $resapan4   = [];
            $anggaran4  = [];
            $resapan5   = [];
            $anggaran5  = [];

            foreach ($sql_anggaran as $v) {
                // 5.2.2.15.02
                if ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 1) {
                    $resapan = $kas->show_resapan_anggaran($year, '01', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 2) {
                    $resapan = $kas->show_resapan_anggaran($year, '02', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 3) {
                    $resapan = $kas->show_resapan_anggaran($year, '03', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 4) {
                    $resapan = $kas->show_resapan_anggaran($year, '04', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 5) {
                    $resapan = $kas->show_resapan_anggaran($year, '05', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 6) {
                    $resapan = $kas->show_resapan_anggaran($year, '06', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 7) {
                    $resapan = $kas->show_resapan_anggaran($year, '07', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 8) {
                    $resapan = $kas->show_resapan_anggaran($year, '08', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 9) {
                    $resapan = $kas->show_resapan_anggaran($year, '09', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 10) {
                    $resapan = $kas->show_resapan_anggaran($year, '10', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 11) {
                    $resapan = $kas->show_resapan_anggaran($year, '11', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.02' && $v->bulan == 12) {
                    $resapan = $kas->show_resapan_anggaran($year, '12', $v->belanja_id);
                    array_push($resapan1, intval($resapan));
                    array_push($anggaran1, intval($v->jumlah));
                }        

                // 5.2.2.15.03
                if ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 1) {
                    $resapan = $kas->show_resapan_anggaran($year, '01', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 2) {
                    $resapan = $kas->show_resapan_anggaran($year, '02', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 3) {
                    $resapan = $kas->show_resapan_anggaran($year, '03', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 4) {
                    $resapan = $kas->show_resapan_anggaran($year, '04', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 5) {
                    $resapan = $kas->show_resapan_anggaran($year, '05', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 6) {
                    $resapan = $kas->show_resapan_anggaran($year, '06', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 7) {
                    $resapan = $kas->show_resapan_anggaran($year, '07', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 8) {
                    $resapan = $kas->show_resapan_anggaran($year, '08', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 9) {
                    $resapan = $kas->show_resapan_anggaran($year, '09', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 10) {
                    $resapan = $kas->show_resapan_anggaran($year, '10', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 11) {
                    $resapan = $kas->show_resapan_anggaran($year, '11', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.15.03' && $v->bulan == 12) {
                    $resapan = $kas->show_resapan_anggaran($year, '12', $v->belanja_id);
                    array_push($resapan2, intval($resapan));
                    array_push($anggaran2, intval($v->jumlah));
                }

                // 5.2.2.16.02
                if ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 1) {
                    $resapan = $kas->show_resapan_anggaran($year, '01', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 2) {
                    $resapan = $kas->show_resapan_anggaran($year, '02', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 3) {
                    $resapan = $kas->show_resapan_anggaran($year, '03', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 4) {
                    $resapan = $kas->show_resapan_anggaran($year, '04', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 5) {
                    $resapan = $kas->show_resapan_anggaran($year, '05', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 6) {
                    $resapan = $kas->show_resapan_anggaran($year, '06', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 7) {
                    $resapan = $kas->show_resapan_anggaran($year, '07', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 8) {
                    $resapan = $kas->show_resapan_anggaran($year, '08', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 9) {
                    $resapan = $kas->show_resapan_anggaran($year, '09', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 10) {
                    $resapan = $kas->show_resapan_anggaran($year, '10', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 11) {
                    $resapan = $kas->show_resapan_anggaran($year, '11', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.16.02' && $v->bulan == 12) {
                    $resapan = $kas->show_resapan_anggaran($year, '12', $v->belanja_id);
                    array_push($resapan3, intval($resapan));
                    array_push($anggaran3, intval($v->jumlah));
                }

                // 5.2.2.17.02
                if ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 1) {
                    $resapan = $kas->show_resapan_anggaran($year, '01', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 2) {
                    $resapan = $kas->show_resapan_anggaran($year, '02', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 3) {
                    $resapan = $kas->show_resapan_anggaran($year, '03', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 4) {
                    $resapan = $kas->show_resapan_anggaran($year, '04', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 5) {
                    $resapan = $kas->show_resapan_anggaran($year, '05', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 6) {
                    $resapan = $kas->show_resapan_anggaran($year, '06', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 7) {
                    $resapan = $kas->show_resapan_anggaran($year, '07', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 8) {
                    $resapan = $kas->show_resapan_anggaran($year, '08', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 9) {
                    $resapan = $kas->show_resapan_anggaran($year, '09', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 10) {
                    $resapan = $kas->show_resapan_anggaran($year, '10', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 11) {
                    $resapan = $kas->show_resapan_anggaran($year, '11', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.02' && $v->bulan == 12) {
                    $resapan = $kas->show_resapan_anggaran($year, '12', $v->belanja_id);
                    array_push($resapan4, intval($resapan));
                    array_push($anggaran4, intval($v->jumlah));
                }

                // 5.2.2.17.03
                if ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 1) {
                    $resapan = $kas->show_resapan_anggaran($year, '01', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 2) {
                    $resapan = $kas->show_resapan_anggaran($year, '02', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 3) {
                    $resapan = $kas->show_resapan_anggaran($year, '03', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 4) {
                    $resapan = $kas->show_resapan_anggaran($year, '04', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 5) {
                    $resapan = $kas->show_resapan_anggaran($year, '05', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 6) {
                    $resapan = $kas->show_resapan_anggaran($year, '06', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 7) {
                    $resapan = $kas->show_resapan_anggaran($year, '07', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 8) {
                    $resapan = $kas->show_resapan_anggaran($year, '08', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 9) {
                    $resapan = $kas->show_resapan_anggaran($year, '09', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 10) {
                    $resapan = $kas->show_resapan_anggaran($year, '10', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 11) {
                    $resapan = $kas->show_resapan_anggaran($year, '11', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                } elseif ($v->belanja->kode_belanja == '5.2.2.17.03' && $v->bulan == 12) {
                    $resapan = $kas->show_resapan_anggaran($year, '12', $v->belanja_id);
                    array_push($resapan5, intval($resapan));
                    array_push($anggaran5, intval($v->jumlah));
                }
            }

            $anggaran = [
                            'kodering' =>
                                [
                                    '5221502' => 
                                                    [
                                                        'deskripsi' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi', 
                                                        'anggaran' => $anggaran1, 
                                                        'resapan'=> $resapan1
                                                    ],
                                    '5221503' => 
                                                    [
                                                        'deskripsi' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                                                        'anggaran' => $anggaran2, 
                                                        'resapan'=> $resapan2
                                                    ], 
                                    '5221602' => 
                                                    [
                                                        'deskripsi' => 'Perjalanan Dinas Dalam Daerah  PNS Non Provinsi',
                                                        'anggaran' => $anggaran3, 
                                                        'resapan'=> $resapan3
                                                    ], 
                                    '5221702' => 
                                                    [
                                                        'deskripsi' => 'Perjalanan Dinas Dalam Daerah Non PNS', 
                                                        'anggaran' => $anggaran4, 
                                                        'resapan'=> $resapan4
                                                    ], 
                                    '5221703' => 
                                                    [
                                                        'deskripsi' => 'Perjalanan Dinas Luar Provinsi Non PNS', 
                                                        'anggaran' => $anggaran5, 
                                                        'resapan'=> $resapan5
                                                    ]
                                ]
                        ];
            return response()->json($anggaran, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
