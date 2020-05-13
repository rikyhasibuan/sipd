<?php

namespace App\Libraries;

/**
 * @author rikyhsb
 */

use App\Models\Akomodasi;
use App\Models\Bop;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use App\Models\DinasBopDriver;
use App\Models\DinasBopInspektur;
use App\Models\DinasBopSekretaris;
use App\Models\DinasBopReviu;
use App\Models\DinasBopSupervisi;
use App\Models\DinasRegular;
use App\Models\Harian;
use App\Models\Kabkota;
use App\Models\Pegawai;
use App\Libraries\Common;

class TimDinas
{
    protected $_common;

    public function __construct()
    {
        $this->_common = new Common();
    }

    /**
     * membuat sebuah array berisi tim dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_tim_bop($parameter)
    {
        $tim = [];
        $query_dinasbop = DinasBop::find($parameter['dinasbop']);
        $diff = date_diff($query_dinasbop->dari, $query_dinasbop->sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Wakil Penanggung Jawab
        $query_pegawai = Pegawai::searchNip($parameter['wakilpenanggungjawab'])->first();
        $query_bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $check_wp = self::check_personil_bop($parameter['dinasbop'], $query_pegawai['nip'], $query_dinasbop->dari, $query_dinasbop->sampai, $parameter['act']);
        $tim['wakilpenanggungjawab']['nip'] = $query_pegawai['nip'];
        $tim['wakilpenanggungjawab']['nama'] = $query_pegawai['nama'];
        $tim['wakilpenanggungjawab']['golongan'] = $query_pegawai['golongan'];
        $tim['wakilpenanggungjawab']['pangkat'] = $query_pegawai['pangkat'];
        $tim['wakilpenanggungjawab']['jabatan'] = $query_pegawai['jabatan'];
        $tim['wakilpenanggungjawab']['hari'] = $durasi;
        if ($check_wp == true) {
            $tim['wakilpenanggungjawab']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['wakilpenanggungjawab']['total'] = $durasi * $query_bop['biaya_per_hari'];
            $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
        } else {
            $tim['wakilpenanggungjawab']['biaya'] = 0;
            $tim['wakilpenanggungjawab']['total'] = 0;
            $total_anggaran += 0;
        }

        // Pengendali Teknis
        $query_pegawai = Pegawai::SearchNip($parameter['pengendaliteknis'])->first();
        $query_bop = Bop::where('jabatan', 'Pengendali Teknis')->first();
        $check_dalnis = self::check_personil_bop($parameter['dinasbop'], $query_pegawai['nip'], $query_dinasbop->dari, $query_dinasbop->sampai, $parameter['act']);
        $tim['pengendaliteknis']['nip'] = $query_pegawai['nip'];
        $tim['pengendaliteknis']['nama'] = $query_pegawai['nama'];
        $tim['pengendaliteknis']['golongan'] = $query_pegawai['golongan'];
        $tim['pengendaliteknis']['pangkat'] = $query_pegawai['pangkat'];
        $tim['pengendaliteknis']['jabatan'] = $query_pegawai['jabatan'];
        $tim['pengendaliteknis']['hari'] = $durasi;
        if ($check_dalnis == true) {
            $tim['pengendaliteknis']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['pengendaliteknis']['total'] = $durasi * $query_bop['biaya_per_hari'];
            $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
        } else {
            $tim['pengendaliteknis']['biaya'] = 0;
            $tim['pengendaliteknis']['total'] = 0;
            $total_anggaran += 0;
        }

        // Ketua Tim
        $query_pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $query_bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_personil_bop($parameter['dinasbop'], $query_pegawai['nip'], $query_dinasbop->dari, $query_dinasbop->sampai, $parameter['act']);
        $tim['ketuatim']['nip'] = $query_pegawai['nip'];
        $tim['ketuatim']['nama'] = $query_pegawai['nama'];
        $tim['ketuatim']['golongan'] = $query_pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $query_pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $query_pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $query_bop['biaya_per_hari'];
            $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
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
            $check_anggota = self::check_personil_bop($parameter['dinasbop'], $query_pegawai['nip'], $query_dinasbop->dari, $query_dinasbop->sampai, $parameter['act']);
            $tim['anggota'][$n]['nip'] = $query_pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $query_pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $query_pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $query_pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $query_pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
                $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
            } else {
                $tim['anggota'][$n]['biaya'] = 0;
                $tim['anggota'][$n]['total'] = 0;
                $total_anggaran += 0;
            }
            $n++;
        }

        return ['tim' => $tim, 'total_anggaran' => $total_anggaran];
    }

    /**
     * membuat sebuah array berisi driver dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_driver_bop($parameter)
    {
        $driver = [];
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        $query_pegawai = Pegawai::searchNip($parameter['driver'])->first();
        $golongan = $this->_common->split_golongan($query_pegawai['golongan']);
        if ($golongan == 'I' OR $golongan == 'II') {
            $jabatan_bop = 'Penunjang Administrasi Kesekretariatan (Gol. I/II)';
        } else {
            $jabatan_bop = 'Penunjang Administrasi Kesekretariatan (Gol. III)';
        }
        $query_bop = Bop::where('jabatan', $jabatan_bop)->first();
        $driver['nip'] = $query_pegawai['nip'];
        $driver['nama'] = $query_pegawai['nama'];
        $driver['golongan'] = $query_pegawai['golongan'];
        $driver['pangkat'] = $query_pegawai['pangkat'];
        $driver['hari'] = $durasi;
        $driver['biaya'] = $query_bop['biaya_per_hari'];
        $driver['total'] = $durasi * $query_bop['biaya_per_hari'];
        $total_anggaran += $durasi * $query_bop['biaya_per_hari'];

        return ['driver' => $driver, 'total_anggaran' => $total_anggaran];
    }

    /**
     * membuat sebuah array berisi driver dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_inspektur_bop($parameter)
    {
        $inspektur = [];
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        $query_pegawai = Pegawai::searchJabatan('Inspektur')->first();
        $query_bop = Bop::where('jabatan', 'Penanggungjawab/Pengendali Mutu')->first();
        $inspektur['nip'] = $query_pegawai['nip'];
        $inspektur['nama'] = $query_pegawai['nama'];
        $inspektur['golongan'] = $query_pegawai['golongan'];
        $inspektur['pangkat'] = $query_pegawai['pangkat'];
        $inspektur['hari'] = $durasi;
        $inspektur['biaya'] = $query_bop['biaya_per_hari'];
        $inspektur['total'] = $durasi * $query_bop['biaya_per_hari'];
        $total_anggaran += $durasi * $query_bop['biaya_per_hari'];

        return ['inspektur' => $inspektur, 'total_anggaran' => $total_anggaran];
    }

    /**
     * membuat sebuah array berisi driver dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_sekretaris_bop($parameter)
    {
        $sekretaris = [];
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        $query_pegawai = Pegawai::searchJabatan('Sekretaris')->first();
        $query_bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $sekretaris['nip'] = $query_pegawai['nip'];
        $sekretaris['nama'] = $query_pegawai['nama'];
        $sekretaris['golongan'] = $query_pegawai['golongan'];
        $sekretaris['pangkat'] = $query_pegawai['pangkat'];
        $sekretaris['hari'] = $durasi;
        $sekretaris['biaya'] = $query_bop['biaya_per_hari'];
        $sekretaris['total'] = $durasi * $query_bop['biaya_per_hari'];
        $total_anggaran += $durasi * $query_bop['biaya_per_hari'];

        return ['sekretaris' => $sekretaris, 'total_anggaran' => $total_anggaran];
    }

    /**
     * membuat sebuah array berisi tim dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_reviu_bop($parameter)
    {
        $tim = [];
        $query_dinasbop = DinasBop::find($parameter['dinasbop']);
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Ketua Tim
        $query_pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $query_bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_reviu_bop($parameter['reviu'], $parameter['dinasbop'], $query_pegawai['nip'], $dari, $sampai, $parameter['act']);

        $tim['ketuatim']['nip'] = $query_pegawai['nip'];
        $tim['ketuatim']['nama'] = $query_pegawai['nama'];
        $tim['ketuatim']['golongan'] = $query_pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $query_pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $query_pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $query_bop['biaya_per_hari'];
            $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
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
            $check_anggota = self::check_reviu_bop($parameter['reviu'], $parameter['dinasbop'], $query_pegawai['nip'], $dari, $sampai, $parameter['act']);

            $tim['anggota'][$n]['nip'] = $query_pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $query_pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $query_pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $query_pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $query_pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
                $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
            } else {
                $tim['anggota'][$n]['biaya'] = 0;
                $tim['anggota'][$n]['total'] = 0;
                $total_anggaran += 0;
            }
            $n++;
        }

        return ['reviu' => $tim, 'total_anggaran' => $total_anggaran];
    }

    /**
     * membuat sebuah array berisi tim supervisi dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_supervisi_bop($parameter)
    {
        $tim = [];
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Ketua Tim
        $query_pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $query_bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_supervisi_bop($parameter['supervisi'], $parameter['dinasbop'], $query_pegawai['nip'], $dari, $sampai, $parameter['act']);

        $tim['ketuatim']['nip'] = $query_pegawai['nip'];
        $tim['ketuatim']['nama'] = $query_pegawai['nama'];
        $tim['ketuatim']['golongan'] = $query_pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $query_pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $query_pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $query_bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $query_bop['biaya_per_hari'];
            $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
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
            $check_anggota = self::check_supervisi_bop($parameter['supervisi'], $parameter['dinasbop'], $query_pegawai['nip'], $dari, $sampai, $parameter['act']);

            $tim['anggota'][$n]['nip'] = $query_pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $query_pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $query_pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $query_pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $query_pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $query_bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $query_bop['biaya_per_hari'];
                $total_anggaran += $durasi * $query_bop['biaya_per_hari'];
            } else {
                $tim['anggota'][$n]['biaya'] = 0;
                $tim['anggota'][$n]['total'] = 0;
                $total_anggaran += 0;
            }
            $n++;
        }

        return ['supervisi' => $tim, 'total_anggaran' => $total_anggaran];
    }

    /**
     * generate tim untuk dinas regular
     *
     * @param array $parameter
     * @return array $callback
     */
    public function generate_tim_regular($parameter)
    {
        $query_kabkota = Kabkota::where('nama_kabkota', $parameter['auditan'])->first();
        $query_harian = Harian::where('kabkota_id', $query_kabkota['id'])->first();
        $diff = date_diff(date_create($parameter['dari']), date_create($parameter['sampai']));
        $durasi = $diff->days + 1;
        $total_harian = 0;
        $total_akomodasi = 0;
        $tim = [];
        $i = 0;

        foreach ($parameter['tim'] as $t) {
            $pegawai = Pegawai::searchNip($t['key'])->first();
            $roman_golongan = $this->_common->split_golongan($pegawai['golongan']);
            $golongan = $this->_common->generate_golongan($roman_golongan);
            $check_personil = self::check_personil_regular($t['key']);

            $tim[$i]['nip'] = $pegawai['nip'];
            $tim[$i]['nama'] = $pegawai['nama'];
            $tim[$i]['pangkat'] = $pegawai['pangkat'];
            $tim[$i]['golongan'] = $pegawai['golongan'];
            $tim[$i]['jabatan'] = $pegawai['jabatan'];
            $tim[$i]['eselon'] = $pegawai['eselon'];
            $tim[$i]['hari'] = $durasi;
            $tim[$i]['inap'] = 0;

            if ($check_personil == true) {
                $tim[$i]['biaya_harian'] = $query_harian[$golongan];
                $tim[$i]['total_harian'] = $durasi * $query_harian[$golongan];
                $tim[$i]['biaya_akomodasi'] = 0;
                $tim[$i]['total_akomodasi'] = 0;
                $total_harian += $durasi * $query_harian[$golongan];
                $total_akomodasi += 0;
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
        return ['tim' => $tim, 'total_harian' => $total_harian, 'total_akomodasi' => $total_akomodasi];
    }

    /**
     * menghitung akomodasi
     *
     * @param int $durasi
     * @param string $tujuan
     * @param array $tim
     * @return array $akomodasi
     */
    public function calculate_regular_accomodation($durasi, $tujuan, $tim)
    {
        $kabkota = Kabkota::where('nama_kabkota', $tujuan)->first();
        $akomodasi = Akomodasi::where('kabkota_id', $kabkota['id'])->first();
        $output = [];
        $total_akomodasi = 0;
        $i = 0;
        foreach ($tim as $v) {
            $roman_golongan = $this->_common->split_golongan($v['golongan']);
            $eselon = $this->_common->generate_eselon($roman_golongan, $v['eselon']);

            $output[$i]['nip'] = $v['nip'];
            $output[$i]['nama'] = $v['nama'];
            $output[$i]['pangkat'] = $v['pangkat'];
            $output[$i]['golongan'] = $v['golongan'];
            $output[$i]['eselon'] = $v['eselon'];
            $output[$i]['jabatan'] = $v['jabatan'];
            $output[$i]['hari'] = $v['hari'];
            $output[$i]['inap'] = $durasi;
            $output[$i]['biaya_harian'] = $v['biaya_harian'];
            $output[$i]['total_harian'] = $v['total_harian'];
            $output[$i]['biaya_akomodasi'] = $akomodasi[$eselon];
            $output[$i]['total_akomodasi'] = $durasi * $akomodasi[$eselon];
            $total_akomodasi += ($durasi * $akomodasi[$eselon]);
            $i++;
        }
        return ['tim'=> $output, 'akomodasi' => $total_akomodasi];
    }

    /**
     * cek personil pada dinas bop apakah personil tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @param int $id_dinasbop
     * @return boolean
     */
    public function check_personil_bop($idtim, $nip, $dari, $sampai, $act)
    {
        $dinasbop = DinasBop::where('dari', $dari)->where('sampai', $sampai)->get();

        if (count($dinasbop) > 0) {
            $i = 0;
            foreach($dinasbop as $x) {
                if ($act == 'create') {
                    $tim = DinasBopTim::where('dinasbop_id', $x->id)->get();
                    if (count($tim) > 0) {
                        foreach ($tim as $v) {
                            if ($v['tim']['wakilpenanggungjawab']['nip'] == $nip) {
                                $i++;
                            }

                            if ($v['tim']['pengendaliteknis']['nip'] == $nip) {
                                $i++;
                            }

                            if ($v['tim']['ketuatim']['nip'] == $nip) {
                                $i++;
                            }

                            foreach ($v['tim']['anggota'] as $y) {
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
                } elseif($act == 'put') {
                    $tim = DinasBopTim::where('dinasbop_id', $x->id)->where('id','!=', $idtim)->get();
                    if (count($tim) > 0) {
                        foreach ($x->tim as $v) {
                            if ($v['tim']['wakilpenanggungjawab']['nip'] == $nip) {
                                $i++;
                            }
                            if ($v['tim']['pengendaliteknis']['nip'] == $nip) {
                                $i++;
                            }
                            if ($v['tim']['ketuatim']['nip'] == $nip) {
                                $i++;
                            }
                            foreach ($v['tim']['anggota'] as $y) {
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
            }
        } else {
            return true;
        }
    }

    /**
     * cek driver pada dinas bop apakah driver tersebut sudah ada dalam pemeriksaan pada rentang waktu tertentu
     *
     * @param array $param
     * @return boolean
     */
    public function check_driver_bop($param)
    {
        $dinasbop = DinasBopDriver::where('dinasbop_id', $param['dinasbop'])
                                    ->where('driver->nip', $param['driver'])
                                    ->where('dari', $param['dari'])
                                    ->where('sampai', $param['sampai'])
                                    ->count();
        if ($dinasbop > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * cek inspektur pada dinas bop apakah inspektur sudah ada dalam pemeriksaan pada rentang waktu tertentu
     *
     * @param array $param
     * @return boolean
     */
    public function check_inspektur_bop($param)
    {
        $dinasbop = DinasBopInspektur::where('dinasbop_id', $param['dinasbop'])
                                        ->where('dari', $param['dari'])
                                        ->where('sampai', $param['sampai'])
                                        ->where('inspektur->nip', $param['inspektur'])
                                        ->count();
        if ($dinasbop > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * cek sekretaris pada dinas bop apakah sekretaris sudah ada dalam pemeriksaan pada rentang waktu tertentu
     *
     * @param array $param
     * @return boolean
     */
    public function check_sekretaris_bop($param)
    {
        $dinasbop = DinasBopSekretaris::where('dinasbop_id', $param['dinasbop'])
                                        ->where('dari', $param['dari'])
                                        ->where('sampai', $param['sampai'])
                                        ->where('sekretaris->nip', $param['sekretaris'])
                                        ->count();
        if ($dinasbop > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * cek reviu pada dinas bop apakah reviu tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @param int $id_dinasbop
     * @return boolean
     */
    public function check_reviu_bop($id, $idtim, $nip, $dari, $sampai, $act)
    {
        if ($act == 'create') {
            $dinasbop = DinasBopReviu::where('dinasbop_id',$id)->where('dari', $dari)->where('sampai', $sampai)->get();
            if (count($dinasbop) > 0) {
                $i = 0;
                foreach ($dinasbop as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }

                    if ($i == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return true;
            }
        } elseif ($act == 'put') {
            $tim = DinasBopReviu::where('dinasbop_id', $id)->where('id','!=', $idtim)->get();
            if (count($tim) > 0) {
                $i = 0;
                foreach ($tim as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }
                    foreach ($v['tim']['anggota'] as $y) {
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
    }

    /**
     * cek supervisi pada dinas bop apakah supervisi tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @param int $id_dinasbop
     * @return boolean
     */
    public function check_supervisi_bop($id, $idtim, $nip, $dari, $sampai, $act)
    {
        if ($act == 'create') {
            $dinasbop = DinasBopSupervisi::where('dinasbop_id',$id)->where('dari', $dari)->where('sampai', $sampai)->get();
            if (count($dinasbop) > 0) {
                $i = 0;
                foreach ($dinasbop as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }

                    if ($i == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return true;
            }
        } elseif ($act == 'put') {
            $tim = DinasBopSupervisi::where('dinasbop_id', $id)->where('id','!=', $idtim)->get();
            if (count($tim) > 0) {
                $i = 0;
                foreach ($tim as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }
                    foreach ($v['tim']['anggota'] as $y) {
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
     * @return object
     */
    public function get_inspektur()
    {
        return Pegawai::where('jabatan', 'Inspektur')->first();
    }

    /**
     * mengambil data pegawai dengan jabatan sebagai sekretaris
     *
     * @return object
     */
    public function get_sekretaris()
    {
        return Pegawai::where('jabatan', 'Sekretaris')->first();
    }
}
