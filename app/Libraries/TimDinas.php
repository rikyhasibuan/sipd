<?php

/*
 * Copyright 2020 rikyhsb.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Libraries;

/**
 *
 * @author rikyhsb
 */

use App\Models\Akomodasi;
use App\Models\Bop;
use App\Models\DinasBop;
use App\Models\DinasRegular;
use App\Models\Harian;
use App\Models\Kabkota;
use App\Models\Pegawai;
use App\Libraries\Common;

class TimDinas
{
    /**
     * membuat sebuah array berisi tim dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_tim_bop($parameter)
    {
        $common = new Common();
        $tim = [];
        $query_dinasbop = DinasBop::find($parameter['dinasbop']);
        $diff = date_diff($query_dinasbop->dari, $query_dinasbop->sampai);
        $total_anggaran = 0;

        // Wakil Penanggung Jawab
        $query_pegawai = Pegawai::searchNip($parameter['wakilpenanggungjawab'])->first();
        $query_bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $check_wp = self::check_personil_bop($query_pegawai['nip']);
        $tim['wakilpenanggungjawab']['nip'] = $query_pegawai['nip'];
        $tim['wakilpenanggungjawab']['nama'] = $query_pegawai['nama'];
        $tim['wakilpenanggungjawab']['golongan'] = $query_pegawai['golongan'];
        $tim['wakilpenanggungjawab']['hari'] = $diff->days;
        if ($check_wp == true) {
            $tim['wakilpenanggungjawab']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['wakilpenanggungjawab']['total'] = $diff->days * $query_bop['biaya_per_hari'];
            $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
        } else {
            $tim['wakilpenanggungjawab']['biaya'] = 0;
            $tim['wakilpenanggungjawab']['total'] = 0;
            $total_anggaran += 0;
        }

        // Pengendali Teknis
        $query_pegawai = Pegawai::SearchNip($parameter['pengendaliteknis'])->first();
        $query_bop = Bop::where('jabatan', 'Pengendali Teknis')->first();
        $check_dalnis = self::check_personil_bop($query_pegawai['nip']);
        $tim['pengendaliteknis']['nip'] = $query_pegawai['nip'];
        $tim['pengendaliteknis']['nama'] = $query_pegawai['nama'];
        $tim['pengendaliteknis']['golongan'] = $query_pegawai['golongan'];
        $tim['pengendaliteknis']['hari'] = $diff->days;
        if ($check_dalnis == true) {
            $tim['pengendaliteknis']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['pengendaliteknis']['total'] = $diff->days * $query_bop['biaya_per_hari'];
            $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
        } else {
            $tim['pengendaliteknis']['biaya'] = 0;
            $tim['pengendaliteknis']['total'] = 0;
            $total_anggaran += 0;
        }

        // Ketua Tim
        $query_pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $query_bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_personil_bop($query_pegawai['nip']);
        $tim['ketuatim']['nip'] = $query_pegawai['nip'];
        $tim['ketuatim']['nama'] = $query_pegawai['nama'];
        $tim['ketuatim']['golongan'] = $query_pegawai['golongan'];
        $tim['ketuatim']['hari'] = $diff->days;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $diff->days * $query_bop['biaya_per_hari'];
            $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $query_pegawai = Pegawai::searchNip($s['key'])->first();
            $query_bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_personil_bop($query_pegawai['nip']);
            $tim['anggota'][$n]['nip'] = $query_pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $query_pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $query_pegawai['golongan'];
            $tim['anggota'][$n]['hari'] = $diff->days;
            $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $diff->days * $query_bop['biaya_per_hari'];
            $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $diff->days * $query_bop['biaya_per_hari'];
                $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
            } else {
                $tim['anggota'][$n]['biaya'] = 0;
                $tim['anggota'][$n]['total'] = 0;
                $total_anggaran += 0;
            }
            $n++;
        }
        
        // Driver
        $query_pegawai = Pegawai::searchNip($parameter['driver'])->first();
        $golongan = $common->split_golongan($query_pegawai['golongan']);
        $check_driver = self::check_personil_bop($query_pegawai['nip']);

        if (($golongan == 'I') || ($golongan == 'II')) {
            $jabatanbop = 'Penunjang Administrasi Kesekretariatan (Gol. I/II)';
        } elseif ($$golongan == 'III') {
            $jabatanbop = 'Penunjang Administrasi Kesekretariatan (Gol. III)';
        }
        
        $query_bop = Bop::where('jabatan', $jabatanbop)->first();
        $tim['driver']['nip'] = $query_pegawai['nip'];
        $tim['driver']['nama'] = $query_pegawai['nama'];
        $tim['driver']['golongan'] = $query_pegawai['golongan'];
        $tim['driver']['hari'] = $diff->days;
        if ($check_driver == true) {
            $tim['driver']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['driver']['total'] = $diff->days * $query_bop['biaya_per_hari'];
            $total_anggaran += $diff->days * $query_bop['biaya_per_hari'];
        } else {
            $tim['driver']['biaya'] = 0;
            $tim['driver']['total'] = 0;
            $total_anggaran += 0;
        }

        $callback = ['tim'=>$tim,'total_anggaran'=>$total_anggaran];
        return $callback;
    }
    
    /**
     * generate tim untuk dinas regular
     *
     * @param array $parameter
     * @return array $callback
     */
    public function generate_tim_regular($parameter)
    {
        $common = new Common();
        $tim = [];
        $query_kabkota = Kabkota::where('nama_kabkota', $parameter['auditan'])->first();
        $query_harian = Harian::where('kabkota_id',$query_kabkota['id'])->first();
        $query_akomodasi = Akomodasi::where('kabkota_id',$query_kabkota['id'])->first();
        $diff = date_diff(date_create($parameter['dari']), date_create($parameter['sampai']));
        $total_harian = 0;
        $total_akomodasi = 0;

        $tim = [];
        $i = 0;
        
        foreach ($parameter['tim'] as $t) {
            $pegawai = Pegawai::searchNip($t['key'])->first();
            $roman_golongan = $common->split_golongan($pegawai['golongan']);
            $eselon = $common->generate_eselon($roman_golongan, $pegawai['eselon']);
            $golongan = $common->generate_golongan($roman_golongan);
            $check_personil = self::check_personil_regular($t['key']);

            $tim[$i]['nip'] = $pegawai['nip'];
            $tim[$i]['nama'] = $pegawai['nama'];
            $tim[$i]['pangkat'] = $pegawai['pangkat'];
            $tim[$i]['golongan'] = $pegawai['golongan'];
            $tim[$i]['jabatan'] = $pegawai['jabatan'];
            $tim[$i]['hari'] = $diff->days;

            if ($check_personil == true) {
                $tim[$i]['biaya_harian'] = $query_harian[$golongan];
                $tim[$i]['total_harian'] = $diff->days * $query_harian[$golongan];
                $tim[$i]['biaya_akomodasi'] = $query_akomodasi[$eselon];
                $tim[$i]['total_akomodasi'] = $diff->days * $query_akomodasi[$eselon];
                $total_harian += $diff->days * $query_harian[$golongan];
                $total_akomodasi += ($diff->days * $query_akomodasi[$eselon]);
            } else {
                $tim[$i]['biaya_harian'] = 0;
                $tim[$i]['total_harian'] = 0;
                $tim[$i]['biaya_akomodasi'] = 0;
                $tim[$i]['total_akomodasi'] = 0;
                $total_harian += 0;
                $total_akomodasi += 0;
            }
            $i++;
        }
        $callback = ['tim'=>$tim, 'total_harian'=>$total_harian, 'total_akomodasi'=>$total_akomodasi];
        return $callback;
    }

    /**
     * cek personil pada dinas bop apakah personil tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @return boolean
     */
    public function check_personil_bop($nip)
    {
        $current_date = date('Y-m-d');
        $dinasbop = DinasBop::where('dari', '<=', $current_date)->where('sampai', '>=', $current_date)->with('tim')->get();

        if (count($dinasbop) > 0) {
            $i = 0;
            foreach ($dinasbop->tim as $v) {
                if ($v['wakilpenanggungjawab']['nip'] == $nip) {
                    $i++;
                } 
                if ($v['pengendaliteknis']['nip'] == $nip) {
                    $i++;
                } 
                if ($v['ketuatim']['nip'] == $nip) {
                    $i++;
                }
                foreach ($v['anggota'] as $y) {
                    if ($y['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }
    }

    /**
     * cek personil pada dinas regular apakah personil tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @return boolean
     */
    public function check_personil_regular($nip)
    {
        $current_date = date('Y-m-d');
        $dinasregular = DinasRegular::where('dari', '<=', $current_date)->where('sampai', '>=', $current_date)->get();
        
        if (count($dinasregular) > 0) {
            $i = 0;
            foreach ($dinasregular->tim as $v) {
                if ($v['nip'] == $nip) {
                    $i++;
                }
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }
    }

    /**
     * mengambil data pegawai dengan jabatan sebagai kepala inspektur
     *
     * @return array $pegawai
     */
    public function get_inspektur()
    {
        $pegawai = Pegawai::where('jabatan', 'Inspektur')->first();
        return $pegawai;
    }

    /**
     * mengambil data pegawai dengan jabatan sebagai sekretaris
     *
     * @return array $pegawai
     */
    public function get_sekretaris()
    {
        $pegawai = Pegawai::where('jabatan', 'Sekretaris')->first();
        return $pegawai;
    }
}
