<?php

namespace App\Libraries;

/**
 * @author rikyhsb
 */

use App\Models\Akomodasi;
use App\Models\Bop;
use App\Models\DinasBop;
use App\Models\DinasBopPengumpulData;
use App\Models\DinasBopPengumpulDataTim;
use App\Models\DinasBopAdministrasi;
use App\Models\DinasBopAdministrasiTim;
use App\Models\DinasBopTim;
use App\Models\DinasBopCustomTim;
use App\Models\DinasBopDriver;
use App\Models\DinasBopInspektur;
use App\Models\DinasBopSekretaris;
use App\Models\DinasBopReviu;
use App\Models\DinasBopSupervisi;
use App\Models\DinasRegular;
use App\Models\DinasBopApproval;
use App\Models\DinasRegularApproval;
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
        $dinasbop = DinasBop::find($parameter['dinasbop']);
        $diff = date_diff($dinasbop->dari, $dinasbop->sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Wakil Penanggung Jawab
        $pegawai = Pegawai::searchNip($parameter['wakilpenanggungjawab'])->first();
        $bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $check_wp = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'tim');
        $tim['wakilpenanggungjawab']['nip'] = $pegawai['nip'];
        $tim['wakilpenanggungjawab']['nama'] = $pegawai['nama'];
        $tim['wakilpenanggungjawab']['golongan'] = $pegawai['golongan'];
        $tim['wakilpenanggungjawab']['pangkat'] = $pegawai['pangkat'];
        $tim['wakilpenanggungjawab']['jabatan'] = $pegawai['jabatan'];
        $tim['wakilpenanggungjawab']['hari'] = $durasi;
        if ($check_wp == true) {
            $tim['wakilpenanggungjawab']['biaya'] = $bop['biaya_per_hari'];
            $tim['wakilpenanggungjawab']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['wakilpenanggungjawab']['biaya'] = 0;
            $tim['wakilpenanggungjawab']['total'] = 0;
            $total_anggaran += 0;
        }

        // Pengendali Teknis
        $pegawai = Pegawai::SearchNip($parameter['pengendaliteknis'])->first();
        $bop = Bop::where('jabatan', 'Pengendali Teknis')->first();
        $check_dalnis = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'tim');
        $tim['pengendaliteknis']['nip'] = $pegawai['nip'];
        $tim['pengendaliteknis']['nama'] = $pegawai['nama'];
        $tim['pengendaliteknis']['golongan'] = $pegawai['golongan'];
        $tim['pengendaliteknis']['pangkat'] = $pegawai['pangkat'];
        $tim['pengendaliteknis']['jabatan'] = $pegawai['jabatan'];
        $tim['pengendaliteknis']['hari'] = $durasi;
        if ($check_dalnis == true) {
            $tim['pengendaliteknis']['biaya'] = $bop['biaya_per_hari'];
            $tim['pengendaliteknis']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['pengendaliteknis']['biaya'] = 0;
            $tim['pengendaliteknis']['total'] = 0;
            $total_anggaran += 0;
        }

        // Ketua Tim
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'tim');
        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'tim');
            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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
     * membuat sebuah array berisi tim custom dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_tim_custom_bop($parameter)
    {
        $tim = [];
        $dinasbop = DinasBop::find($parameter['dinasbop']);
        $diff = date_diff($dinasbop->dari, $dinasbop->sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Penanggung Jawab
        $pegawai = Pegawai::searchNip($parameter['penanggungjawab'])->first();
        $bop = Bop::where('jabatan', 'Penanggungjawab/Pengendali Mutu')->first();
        $check_pj = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'custom');

        $tim['penanggungjawab']['nip'] = $pegawai['nip'];
        $tim['penanggungjawab']['nama'] = $pegawai['nama'];
        $tim['penanggungjawab']['golongan'] = $pegawai['golongan'];
        $tim['penanggungjawab']['pangkat'] = $pegawai['pangkat'];
        $tim['penanggungjawab']['jabatan'] = $pegawai['jabatan'];
        $tim['penanggungjawab']['hari'] = $durasi;
        if ($check_pj == true) {
            $tim['penanggungjawab']['biaya'] = $bop['biaya_per_hari'];
            $tim['penanggungjawab']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['penanggungjawab']['biaya'] = 0;
            $tim['penanggungjawab']['total'] = 0;
            $total_anggaran += 0;
        }

        // Wakil Penanggung Jawab
        $pegawai = Pegawai::searchNip($parameter['wakilpenanggungjawab'])->first();
        $bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $check_wp = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'custom');
        $tim['wakilpenanggungjawab']['nip'] = $pegawai['nip'];
        $tim['wakilpenanggungjawab']['nama'] = $pegawai['nama'];
        $tim['wakilpenanggungjawab']['golongan'] = $pegawai['golongan'];
        $tim['wakilpenanggungjawab']['pangkat'] = $pegawai['pangkat'];
        $tim['wakilpenanggungjawab']['jabatan'] = $pegawai['jabatan'];
        $tim['wakilpenanggungjawab']['hari'] = $durasi;
        if ($check_wp == true) {
            $tim['wakilpenanggungjawab']['biaya'] = $bop['biaya_per_hari'];
            $tim['wakilpenanggungjawab']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['wakilpenanggungjawab']['biaya'] = 0;
            $tim['wakilpenanggungjawab']['total'] = 0;
            $total_anggaran += 0;
        }

        // Pengendali Teknis
        $pegawai = Pegawai::SearchNip($parameter['pengendaliteknis'])->first();
        $bop = Bop::where('jabatan', 'Pengendali Teknis')->first();
        $check_dalnis = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'custom');
        $tim['pengendaliteknis']['nip'] = $pegawai['nip'];
        $tim['pengendaliteknis']['nama'] = $pegawai['nama'];
        $tim['pengendaliteknis']['golongan'] = $pegawai['golongan'];
        $tim['pengendaliteknis']['pangkat'] = $pegawai['pangkat'];
        $tim['pengendaliteknis']['jabatan'] = $pegawai['jabatan'];
        $tim['pengendaliteknis']['hari'] = $durasi;
        if ($check_dalnis == true) {
            $tim['pengendaliteknis']['biaya'] = $bop['biaya_per_hari'];
            $tim['pengendaliteknis']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['pengendaliteknis']['biaya'] = 0;
            $tim['pengendaliteknis']['total'] = 0;
            $total_anggaran += 0;
        }

        // Ketua Tim
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'custom');
        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'custom');
            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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
     * membuat sebuah array berisi tim dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_pengumpuldata_bop($parameter)
    {
        $tim = [];
        $dinasbop = DinasBopPengumpulData::find($parameter['pengumpuldata']);
        $diff = date_diff(date_create($dinasbop->dari), date_create($dinasbop->sampai));
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Ketua Tim
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'pengumpuldata');
        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'pengumpuldata');
            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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
     * membuat sebuah array berisi tim dinas bop
     * @param array $parameter
     * @return array $callback
     */
    public function generate_administrasi_bop($parameter)
    {
        $tim = [];
        $dinasbop = DinasBopAdministrasi::find($parameter['administrasi']);
        $diff = date_diff(date_create($dinasbop->dari), date_create($dinasbop->sampai));
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Ketua Tim
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'administrasi');
        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dinasbop->dari, $dinasbop->sampai, $parameter['act'], 'administrasi');
            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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

        $pegawai = Pegawai::searchNip($parameter['driver'])->first();
        $golongan = $this->_common->split_golongan($pegawai['golongan']);
        if ($golongan == 'I' or $golongan == 'II') {
            $jabatan_bop = 'Penunjang Administrasi Kesekretariatan (Gol. I/II)';
        } else {
            $jabatan_bop = 'Penunjang Administrasi Kesekretariatan (Gol. III)';
        }
        $bop = Bop::where('jabatan', $jabatan_bop)->first();
        $driver['nip'] = $pegawai['nip'];
        $driver['nama'] = $pegawai['nama'];
        $driver['golongan'] = $pegawai['golongan'];
        $driver['pangkat'] = $pegawai['pangkat'];
        $driver['hari'] = $durasi;
        $driver['biaya'] = $bop['biaya_per_hari'];
        $driver['total'] = $durasi * $bop['biaya_per_hari'];
        $total_anggaran += $durasi * $bop['biaya_per_hari'];

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

        $pegawai = Pegawai::searchJabatan('Inspektur')->first();
        $bop = Bop::where('jabatan', 'Penanggungjawab/Pengendali Mutu')->first();
        $inspektur['nip'] = $pegawai['nip'];
        $inspektur['nama'] = $pegawai['nama'];
        $inspektur['golongan'] = $pegawai['golongan'];
        $inspektur['pangkat'] = $pegawai['pangkat'];
        $inspektur['hari'] = $durasi;
        $inspektur['biaya'] = $bop['biaya_per_hari'];
        $inspektur['total'] = $durasi * $bop['biaya_per_hari'];
        $total_anggaran += $durasi * $bop['biaya_per_hari'];

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

        $pegawai = Pegawai::searchJabatan('Sekretaris')->first();
        $bop = Bop::where('jabatan', 'Wakil Penanggungjawab/Suvervisi')->first();
        $sekretaris['nip'] = $pegawai['nip'];
        $sekretaris['nama'] = $pegawai['nama'];
        $sekretaris['golongan'] = $pegawai['golongan'];
        $sekretaris['pangkat'] = $pegawai['pangkat'];
        $sekretaris['hari'] = $durasi;
        $sekretaris['biaya'] = $bop['biaya_per_hari'];
        $sekretaris['total'] = $durasi * $bop['biaya_per_hari'];
        $total_anggaran += $durasi * $bop['biaya_per_hari'];

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
        $dari = date_create($parameter['dari']);
        $sampai = date_create($parameter['sampai']);
        $diff = date_diff($dari, $sampai);
        $durasi = $diff->days + 1;
        $total_anggaran = 0;

        // Ketua Tim
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dari, $sampai, $parameter['act'], 'reviu');

        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dari, $sampai, $parameter['act'], 'reviu');

            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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
        $pegawai = Pegawai::searchNip($parameter['ketuatim'])->first();
        $bop = Bop::where('jabatan', 'Ketua Tim')->first();
        $check_ketua = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dari, $sampai, $parameter['act'], 'supervisi');

        $tim['ketuatim']['nip'] = $pegawai['nip'];
        $tim['ketuatim']['nama'] = $pegawai['nama'];
        $tim['ketuatim']['golongan'] = $pegawai['golongan'];
        $tim['ketuatim']['pangkat'] = $pegawai['pangkat'];
        $tim['ketuatim']['jabatan'] = $pegawai['jabatan'];
        $tim['ketuatim']['hari'] = $durasi;
        if ($check_ketua == true) {
            $tim['ketuatim']['biaya'] = $bop['biaya_per_hari'];
            $tim['ketuatim']['total'] = $durasi * $bop['biaya_per_hari'];
            $total_anggaran += $durasi * $bop['biaya_per_hari'];
        } else {
            $tim['ketuatim']['biaya'] = 0;
            $tim['ketuatim']['total'] = 0;
            $total_anggaran += 0;
        }

        // Anggota Tim
        $n = 0;
        foreach ($parameter['anggota'] as $s) {
            $pegawai = Pegawai::searchNip($s['key'])->first();
            $bop = Bop::where('jabatan', 'Anggota Tim')->first();
            $check_anggota = self::check_dinas_bop($parameter['dinasbop'], $parameter['idtim'], $pegawai['nip'], $dari, $sampai, $parameter['act'], 'supervisi');

            $tim['anggota'][$n]['nip'] = $pegawai['nip'];
            $tim['anggota'][$n]['nama'] = $pegawai['nama'];
            $tim['anggota'][$n]['golongan'] = $pegawai['golongan'];
            $tim['anggota'][$n]['pangkat'] = $pegawai['pangkat'];
            $tim['anggota'][$n]['jabatan'] = $pegawai['jabatan'];
            $tim['anggota'][$n]['hari'] = $durasi;
            $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
            $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
            if ($check_anggota == true) {
                $tim['anggota'][$n]['biaya'] = $bop['biaya_per_hari'];
                $tim['anggota'][$n]['total'] = $durasi * $bop['biaya_per_hari'];
                $total_anggaran += $durasi * $bop['biaya_per_hari'];
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
            $check_personil = self::check_personil_regular($parameter['act'], $parameter['id'], $parameter['dari'], $parameter['sampai'], $t['key']);

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
    public function calculate_regular_accomodation($pdreguler, $durasi, $tujuan, $tim)
    {
        $dinasreguler = DinasRegular::find($pdreguler);

        $kabkota = Kabkota::where('nama_kabkota', $tujuan)->first();
        $akomodasi = Akomodasi::where('kabkota_id', $kabkota['id'])->first();
        $output = [];
        $total_akomodasi = 0;
        $i = 0;
        foreach ($tim as $v) {
            $roman_golongan = $this->_common->split_golongan($v['golongan']);
            $eselon = $this->_common->generate_eselon($roman_golongan, $v['eselon']);
            $check_personil = self::check_personil_regular('put', $pdreguler, $dinasreguler->dari, $dinasreguler->sampai, $v['nip']);

            $output[$i]['nip'] = $v['nip'];
            $output[$i]['nama'] = $v['nama'];
            $output[$i]['pangkat'] = $v['pangkat'];
            $output[$i]['golongan'] = $v['golongan'];
            $output[$i]['eselon'] = $v['eselon'];
            $output[$i]['jabatan'] = $v['jabatan'];
            $output[$i]['hari'] = $v['hari'];
            $output[$i]['inap'] = $durasi;

            if ($check_personil == true) {
                $output[$i]['biaya_harian'] = $v['biaya_harian'];
                $output[$i]['total_harian'] = $v['total_harian'];
                $output[$i]['biaya_akomodasi'] = $akomodasi[$eselon];
                $output[$i]['total_akomodasi'] = $durasi * $akomodasi[$eselon];
                $total_akomodasi += ($durasi * $akomodasi[$eselon]);
            } else {
                $output[$i]['biaya_harian'] = $v['biaya_harian'];
                $output[$i]['total_harian'] = $v['total_harian'];
                $output[$i]['biaya_akomodasi'] = 0;
                $output[$i]['total_akomodasi'] =0;
                $total_akomodasi += ($durasi * $akomodasi[$eselon]);
            }
            $i++;
        }
        return ['tim'=> $output, 'akomodasi' => $total_akomodasi];
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
            ->where(function ($query) use ($param) {
                $query->whereBetween('dari', [$param['dari'],$param['sampai']])
                ->orWhereBetween('sampai', [$param['dari'], $param['sampai']]);
            })->count();
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
            ->where(function ($query) use ($param) {
                $query->whereBetween('dari', [$param['dari'], $param['sampai']])
                ->orWhereBetween('sampai', [$param['dari'], $param['sampai']]);
            })->count();
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
            ->where(function ($query) use ($param) {
                $query->whereBetween('dari', [$param['dari'],$param['sampai']])
                    ->orWhereBetween('sampai', [$param['dari'], $param['sampai']]);
            })->count();
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
    public function check_dinas_bop($id, $idtim, $nip, $dari, $sampai, $act, $tipe)
    {
        if ($act == 'create') {
            $bop = self::check_bop_query_create($dari, $sampai);
            $reguler = DinasRegular::whereBetween('dari', [$dari, $sampai])->orWhereBetween('sampai', [$dari,$sampai])->get();

            $i = 0;
            if (count($reguler) > 0) {
                foreach ($reguler as $y) {
                    foreach ($y->tim as $v) {
                        if ($v['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($bop['dinasbopreviu']) > 0) {
                foreach ($bop['dinasbopreviu'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($bop['dinasbopsupervisi']) > 0) {
                foreach ($bop['dinasbopsupervisi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($bop['dinasboptim']) > 0) {
                foreach ($bop['dinasboptim'] as $v) {
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
            }

            if (count($bop['dinasboppengumpuldata']) > 0) {
                foreach ($bop['dinasboppengumpuldata'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($bop['dinasbopadministrasi']) > 0) {
                foreach ($bop['dinasbopadministrasi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($bop['dinasbopcustom']) > 0) {
                foreach ($bop['dinasbopcustom'] as $v) {
                    if ($v['tim']['penanggungjawab']['nip'] == $nip) {
                        $i++;
                    }

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
            }

            if (count($bop['dinasbopinspektur']) > 0) {
                foreach ($bop['dinasbopinspektur'] as $v) {
                    if ($v['inspektur']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if (count($bop['dinasbopsekretaris']) > 0) {
                foreach ($bop['dinasbopsekretaris'] as $v) {
                    if ($v['sekretaris']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if (count($bop['dinasbopdriver']) > 0) {
                foreach ($bop['dinasbopdriver'] as $v) {
                    if ($v['driver']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }
        } elseif ($act == 'put') {
            $bop = self::check_bop_query_put($id, $idtim, $tipe, $dari, $sampai);
            $reguler = DinasRegular::whereBetween('dari', [$dari, $sampai])->orWhereBetween('sampai', [$dari, $sampai])->get();

            $i = 0;
            if (count($reguler) > 0) {
                foreach ($reguler as $y) {
                    foreach ($y->tim as $v) {
                        if ($v['nip'] == $nip) {
                            if ($v['total_harian'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasbopreviu']) > 0) {
                foreach ($bop['dinasbopreviu'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($v['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasbopsupervisi']) > 0) {
                foreach ($bop['dinasbopsupervisi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($v['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasboptim']) > 0) {
                foreach ($bop['dinasboptim'] as $v) {
                    if ($v['tim']['wakilpenanggungjawab']['nip'] == $nip) {
                        if ($v['tim']['wakilpenanggungjawab']['total'] != 0) {
                            $i++;
                        }
                    }

                    if ($v['tim']['pengendaliteknis']['nip'] == $nip) {
                        if ($v['tim']['pengendaliteknis']['total'] != 0) {
                            $i++;
                        }
                    }

                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasboppengumpuldata']) > 0) {
                foreach ($bop['dinasboppengumpuldata'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasbopadministrasi']) > 0) {
                foreach ($bop['dinasbopadministrasi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($bop['dinasbopcustom']) > 0) {
                foreach ($bop['dinasbopcustom'] as $v) {
                    if ($v['tim']['penanggungjawab']['nip'] == $nip) {
                        $i++;
                    }

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
            }

            if (count($bop['dinasbopinspektur']) > 0) {
                foreach ($bop['dinasbopinspektur'] as $v) {
                    if ($v['inspektur']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if (count($bop['dinasbopsekretaris']) > 0) {
                foreach ($bop['dinasbopsekretaris'] as $v) {
                    if ($v['sekretaris']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if (count($bop['dinasbopdriver']) > 0) {
                foreach ($bop['dinasbopdriver'] as $v) {
                    if ($v['driver']['nip'] == $nip) {
                        $i++;
                    }
                }
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function check_bop_query_create($dari, $sampai)
    {
        $dinasbop = DinasBop::whereBetween('dari', [$dari, $sampai])->orWhereBetween('sampai', [$dari, $sampai])->get();
        if (count($dinasbop) > 0) {
            $dinasbop_id = [];
            foreach ($dinasbop as $d) {
                array_push($dinasbop_id, $d->id);
            }

            $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
            $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
        } else {
            $dinasbopinspektur = [];
            $dinasbopsekretaris = [];
            $dinasbopdriver = [];
            $dinasbopreviu = [];
            $dinasbopsupervisi = [];
            $dinasboptim = [];
            $dinasboppengumpuldata = [];
            $dinasbopadministrasi = [];
            $dinasbopcustom = [];
        }

        $response = [
            'dinasbopreviu' => $dinasbopreviu,
            'dinasbopsupervisi' => $dinasbopsupervisi,
            'dinasboptim' => $dinasboptim,
            'dinasbopcustom' => $dinasbopcustom,
            'dinasboppengumpuldata' => $dinasboppengumpuldata,
            'dinasbopadministrasi' => $dinasbopadministrasi,
            'dinasbopinspektur' => $dinasbopinspektur,
            'dinasbopsekretaris' => $dinasbopsekretaris,
            'dinasbopdriver' => $dinasbopdriver
        ];

        return $response;
    }

    public function check_bop_query_put($id, $idtim, $tipe, $dari, $sampai)
    {
        $dinasboptim = [];
        $dinasbopreviu = [];
        $dinasbopsupervisi = [];
        $dinasboppengumpuldata = [];
        $dinasbopadministrasi = [];
        $dinasbopcustom = [];
        $dinasbopinspektur = [];
        $dinasbopsekretaris = [];
        $dinasbopdriver = [];

        $dinasbop = DinasBop::whereBetween('dari', [$dari, $sampai])
            ->orWhereBetween('sampai', [$dari,$sampai])->get();

        $dinasbop_id = [];
        foreach ($dinasbop as $d) {
            array_push($dinasbop_id, $d->id);
        }

        switch ($tipe) {
            case 'tim':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
            case 'reviu':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
            case 'supervisi':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
            case 'pengumpuldata':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
            case 'administrasi':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
            case 'custom':
                $dinasboptim = DinasBopTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopreviu = DinasBopReviu::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsupervisi = DinasBopSupervisi::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasboppengumpuldata = DinasBopPengumpulDataTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopadministrasi = DinasBopAdministrasiTim::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopcustom = DinasBopCustomTim::whereIn('dinasbop_id', $dinasbop_id)->where('id', '!=', $idtim)->get();
                $dinasbopinspektur = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopsekretaris = DinasBopSekretaris::whereIn('dinasbop_id', $dinasbop_id)->get();
                $dinasbopdriver = DinasBopInspektur::whereIn('dinasbop_id', $dinasbop_id)->get();
            break;
        }

        $response = [
            'dinasbopreviu' => $dinasbopreviu,
            'dinasbopsupervisi' => $dinasbopsupervisi,
            'dinasboptim' => $dinasboptim,
            'dinasbopcustom' => $dinasbopcustom,
            'dinasboppengumpuldata' => $dinasboppengumpuldata,
            'dinasbopadministrasi' => $dinasbopadministrasi,
            'dinasbopinspektur' => $dinasbopinspektur,
            'dinasbopsekretaris' => $dinasbopsekretaris,
            'dinasbopdriver' => $dinasbopdriver
        ];

        return $response;
    }

    /**
     * cek personil pada dinas regular apakah personil tersebut sudah ada dalam tim lain atau belum
     *
     * @param string $nip
     * @return boolean
     */
    public function check_personil_regular($act, $id, $dari, $sampai, $nip)
    {
        if ($act == 'create') {
            $dinasbop = self::check_bop_query_create($dari, $sampai);
            $dinasreguler = DinasRegular::whereBetween('dari', [$dari, $sampai])
            ->orWhereBetween('sampai', [$dari, $sampai])->get();

            $i = 0;
            if (count($dinasreguler) > 0) {
                foreach ($dinasreguler as $y) {
                    foreach ($y->tim as $v) {
                        if ($v['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopreviu']) > 0) {
                foreach ($dinasbop['dinasbopreviu'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopsupervisi']) > 0) {
                foreach ($dinasbop['dinasbopsupervisi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($dinasbop['dinasboptim']) > 0) {
                foreach ($dinasbop['dinasboptim'] as $v) {
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
            }

            if (count($dinasbop['dinasboppengumpuldata']) > 0) {
                foreach ($dinasbop['dinasboppengumpuldata'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopadministrasi']) > 0) {
                foreach ($dinasbop['dinasbopadministrasi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        $i++;
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            $i++;
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopcustom']) > 0) {
                foreach ($dinasbop['dinasbopcustom'] as $v) {
                    if ($v['tim']['penanggungjawab']['nip'] == $nip) {
                        $i++;
                    }

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
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }
        } elseif ($act == 'put') {
            $dinasbop = self::check_bop_query_create($dari, $sampai);
            $dinasreguler = DinasRegular::where(function ($query) use ($dari, $sampai) {
                $query->whereBetween('dari', [$dari, $sampai])
                ->orWhereBetween('sampai', [$dari, $sampai]);
            })->where('id', '!=', $id)->get();

            $i = 0;
            if (count($dinasreguler) > 0) {
                $x = 0;
                foreach ($dinasreguler as $y) {
                    foreach ($y->tim as $v) {
                        if ($v['nip'] == $nip) {
                            $x++;
                            if ($v['total_harian'] != 0 && $x == 1) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopreviu']) > 0) {
                foreach ($dinasbop['dinasbopreviu'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($v['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopsupervisi']) > 0) {
                foreach ($dinasbop['dinasbopsupervisi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($v['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasboptim']) > 0) {
                foreach ($dinasbop['dinasboptim'] as $v) {
                    if ($v['tim']['wakilpenanggungjawab']['nip'] == $nip) {
                        if ($v['tim']['wakilpenanggungjawab']['total'] != 0) {
                            $i++;
                        }
                    }

                    if ($v['tim']['pengendaliteknis']['nip'] == $nip) {
                        if ($v['tim']['pengendaliteknis']['total'] != 0) {
                            $i++;
                        }
                    }

                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasboppengumpuldata']) > 0) {
                foreach ($dinasbop['dinasboppengumpuldata'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopadministrasi']) > 0) {
                foreach ($dinasbop['dinasbopadministrasi'] as $v) {
                    if ($v['tim']['ketuatim']['nip'] == $nip) {
                        if ($v['tim']['ketuatim']['total'] != 0) {
                            $i++;
                        }
                    }

                    foreach ($v['tim']['anggota'] as $y) {
                        if ($y['nip'] == $nip) {
                            if ($y['total'] != 0) {
                                $i++;
                            }
                        }
                    }
                }
            }

            if (count($dinasbop['dinasbopcustom']) > 0) {
                foreach ($dinasbop['dinasbopcustom'] as $v) {
                    if ($v['tim']['penanggungjawab']['nip'] == $nip) {
                        $i++;
                    }

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
            }

            if ($i == 0) {
                return true;
            } else {
                return false;
            }
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

    /**
     * mengambil data pegawai dengan jabatan sebagai sekretaris daerah
     *
     * @return object
     */
    public function get_sekda()
    {
        return Pegawai::where('jabatan', 'Sekretaris Daerah')->first();
    }

    public function generate_approval_bop($id)
    {
        $tabs = [
            'tim',
            'driver',
            'sekretaris',
            'inspektur',
            'reviu',
            'supervisi',
            'pengumpuldata',
            'administrasi',
            'custom'
        ];

        foreach ($tabs as $v) {
            $approval = new DinasBopApproval();
            $approval->dinasbop_id = $id;
            $approval->tab = $v;
            $approval->inspektur = ['catatan'=>[], 'approval'=>0];
            $approval->sekretaris = ['catatan'=>[], 'approval'=>0];
            $approval->kassubag = ['catatan'=>[], 'approval'=>0];
            $approval->lock = 0;
            $approval->created_at = date('Y-m-d H:i:s');
            $approval->save();
        }
    }

    public function generate_approval_regular($id)
    {
        $approval = new DinasRegularApproval;
        $approval->dinasregular_id = $id;
        $approval->inspektur = ['catatan'=>[], 'approval'=>0];
        $approval->sekretaris = ['catatan'=>[], 'approval'=>0];
        $approval->kassubag = ['catatan'=>[], 'approval'=>0];
        $approval->lock = 0;
        $approval->created_at = date('Y-m-d H:i:s');
        $approval->save();
    }
}
