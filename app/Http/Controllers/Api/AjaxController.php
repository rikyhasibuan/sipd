<?php

namespace App\Http\Controllers\Api;

use App\Models\DinasBopPengumpulDataTim;
use App\Models\DinasBopAdministrasiTim;
use App\Models\DinasBopTim;
use App\Models\Kegiatan;
use App\Models\Belanja;
use App\Models\IrbanKabkota;
use App\Models\IrbanSkpd;
use App\Models\IrbanPokja;
use App\Models\HargaBbm;
use App\Models\Pangkat;
use App\Libraries\Common;
use App\Libraries\KasAnggaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * AjaxController class
 */
class AjaxController extends Controller
{
    /**
     * menampilkan data kegiatan berdasarkan program tertentu
     * @param Request $request
     * @return JsonResponse
     */
    public function show_kegiatan_by_program(Request $request)
    {
        return response()->json(Kegiatan::where('program_id', $request['program'])->get(), 200);
    }

    /**
     * menampilkan data belanja berdasarkan kegiatan tertentu
     * @param Request $request
     * @return JsonResponse
     */
    public function show_belanja_by_kegiatan(Request $request)
    {
        return response()->json(Belanja::where('kegiatan_id', $request['kegiatan'])->get(), 200);
    }

    /**
     * menampilkan total anggaran yang tersedia pada tahun dan kode belanja tertentu
     * @param Request $request
     * @return JsonResponse
     */
    public function show_total_anggaran(Request $request)
    {
        $anggaran = new KasAnggaran();
        $common = new Common();
        $tahun = $common->generate_year_from_date($request->input('tahun'));
        $belanja = $request->input('belanja');
        $totalanggaran = $anggaran->show_total_anggaran($tahun, $belanja);
        return response()->json(['total_anggaran'=>$totalanggaran], 200);
    }

    /**
     * menampilkan sisa anggaran pada tahun dan kode belanja tertentu
     * @param Request $request
     * @return JsonResponse
     */
    public function show_sisa_anggaran(Request $request)
    {
        $common = new Common();
        $tahun = $common->generate_year_from_date($request->input('tahun'));
        $kegiatan = $request->input('kegiatan');

        $kas = new KasAnggaran();
        $sisa_anggaran = $kas->show_sisa_anggaran($tahun, '', $kegiatan);

        return response()->json(['sisa_anggaran' => $sisa_anggaran], 200);
    }

    /**
     * menampilkan dinas / auditan berdasarkan irban tertentu pada dinas BOP
     * @param Request $request
     * @return JsonResponse
     */
    public function show_tujuan_bop(Request $request)
    {
        $response = [];
        if ($request['dinas'] == 'tim') {
            if ($request['act'] == 'create') {
                $dinasboptim = DinasBopTim::where('dinasbop_id', $request['dinasbop'])->get();

                if (count($dinasboptim) > 0) {
                    $auditan = [];

                    foreach ($dinasboptim as $v) {
                        array_push($auditan, $v->auditan);
                    }

                    $kabkota = IrbanKabkota::with(['kabkota' => function ($query) use ($auditan) {
                            $query->whereNotIn('kabkota.nama_kabkota', $auditan);
                    }])->where('irban_id', $request['irban'])->get();

                    $skpd = IrbanSkpd::where('irban_id', $request['irban'])
                        ->with(['skpd' => function ($query) use ($auditan) {
                            $query->whereNotIn('nama_skpd', $auditan);
                        }])->get();

                    foreach ($kabkota as $v) {
                        if ($v->kabkota != null) {
                            $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                        }
                    }

                    foreach ($skpd as $v) {
                        if ($v->skpd != null) {
                            $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                        }
                    }
                } else {
                    $kabkota = IrbanKabkota::where('irban_id', $request['irban'])->with('kabkota')->get();
                    $skpd = IrbanSkpd::where('irban_id', $request['irban'])->with('skpd')->get();

                    foreach ($kabkota as $v) {
                        $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                    }

                    foreach ($skpd as $v) {
                        $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                    }
                }
            } else {
                $kabkota = IrbanKabkota::where('irban_id', $request['irban'])->with('kabkota')->get();
                $skpd = IrbanSkpd::where('irban_id', $request['irban'])->with('skpd')->get();

                foreach ($kabkota as $v) {
                    $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                }

                foreach ($skpd as $v) {
                    $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                }
            }
        } elseif ($request['dinas'] == 'pengumpuldata') {
            $pengumpuldata = DinasBopPengumpulDataTim::where('dinasbop_id', $request['dinasbop'])->get();

            if (count($pengumpuldata) > 0) {
                $auditan = [];
                foreach ($pengumpuldata as $v) {
                    array_push($auditan, $v->auditan);
                }

                $kabkota = IrbanKabkota::where('irban_id', $request['irban'])
                    ->with(['kabkota' => function ($query) use ($auditan) {
                        $query->whereNotIn('nama_kabkota', $auditan);
                    }])->get();

                $skpd = IrbanSkpd::where('irban_id', $request['irban'])
                    ->with(['skpd' => function ($query) use ($auditan) {
                        $query->whereNotIn('nama_skpd', $auditan);
                    }])->get();

                foreach ($kabkota as $v) {
                    if ($v->kabkota != null) {
                        $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                    }
                }

                foreach ($skpd as $v) {
                    if ($v->skpd != null) {
                        $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                    }
                }
            } else {
                $kabkota = IrbanKabkota::where('irban_id', $request['irban'])->with('kabkota')->get();
                $skpd = IrbanSkpd::where('irban_id', $request['irban'])->with('skpd')->get();

                foreach ($kabkota as $v) {
                    $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                }

                foreach ($skpd as $v) {
                    $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                }
            }
        } elseif ($request['dinas'] == 'administrasi') {
            $administrasi = DinasBopAdministrasiTim::where('dinasbop_id', $request['dinasbop'])->get();

            if (count($administrasi) > 0) {
                $auditan = [];
                foreach ($administrasi as $v) {
                    array_push($auditan, $v->auditan);
                }

                $kabkota = IrbanKabkota::where('irban_id', $request['irban'])
                    ->with(['kabkota' => function ($query) use ($auditan) {
                        $query->whereNotIn('nama_kabkota', $auditan);
                    }])->get();

                $skpd = IrbanSkpd::where('irban_id', $request['irban'])
                    ->with(['skpd' => function ($query) use ($auditan) {
                        $query->whereNotIn('nama_skpd', $auditan);
                    }])->get();

                foreach ($kabkota as $v) {
                    if ($v->kabkota != null) {
                        $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                    }
                }

                foreach ($skpd as $v) {
                    if ($v->skpd != null) {
                        $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                    }
                }
            } else {
                $kabkota = IrbanKabkota::where('irban_id', $request['irban'])->with('kabkota')->get();
                $skpd = IrbanSkpd::where('irban_id', $request['irban'])->with('skpd')->get();

                foreach ($kabkota as $v) {
                    $response['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                }

                foreach ($skpd as $v) {
                    $response['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                }
            }
        }

        return response()->json($response, 200);
    }

    /**
     * menampilkan pokja berdasarkan irban tertentu pada dinas BOP
     * @param Request $request
     * @return JsonResponse
     */
    public function show_personil_bop(Request $request)
    {
        $pokja = IrbanPokja::where('irban_id', $request['irban'])->with('pegawai')->get();
        $irbanpokja = [
            'wakilpenanggungjawab'=>[],
            'pengendaliteknis'=>[],
            'ketuatim'=>[],
            'anggota'=>[]
        ];

        $jabatan_wp = [
            'Inspektur Pembantu Bidang Pemerintahan dan Kesejahteraan Masyarakat',
            'Inspektur Pembantu Bidang Administrasi',
            'Inspektur Pembantu Bidang Khusus',
            'Inspektur Pembantu Bidang Perekonomian dan Pembangunan'
        ];

        $jabatan_dalnis = [
            'Auditor Madya',
            'Pengawas Pemerintahan Madya'
        ];

        $jabatan_ketua = [
            'Auditor Madya',
            'Pengawas Pemerintahan Madya',
            'Pengawas Pemerintahan Muda'
        ];

        foreach ($pokja as $v) {
            if (in_array($v->pegawai->jabatan, $jabatan_wp)) {
                array_push($irbanpokja['wakilpenanggungjawab'], $v->pegawai);
            }

            if (in_array($v->pegawai->jabatan, $jabatan_dalnis)) {
                array_push($irbanpokja['pengendaliteknis'], $v->pegawai);
            }

            if (in_array($v->pegawai->jabatan, $jabatan_ketua)) {
                array_push($irbanpokja['ketuatim'], $v->pegawai);
            }

            array_push($irbanpokja['anggota'], $v->pegawai);
        }

        return response()->json($irbanpokja, 200);
    }

    /**
     * menampilkan dinas / auditan berdasarkan irban tertentu pada dinas regular
     * @param Request $request
     * @return JsonResponse
     */
    public function show_tujuan_regular(Request $request)
    {
        $kabkota = IrbanKabkota::where('irban_id', $request['irban'])->with('kabkota')->get();
        $response = [];
        foreach ($kabkota as $v) {
            $response[$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        return response()->json($response, 200);
    }

    /**
     * menampilkan personil berdasarkan irban tertentu pada dinas regular
     * @param Request $request
     * @return JsonResponse
     */
    public function show_personil_regular(Request $request)
    {
        $pokja = IrbanPokja::where('irban_id', $request['irban'])->with('pegawai')->get();
        return response()->json($pokja, 200);
    }

    /**
     * hitung harga bbm
     * @param Request $request
     * @return JsonResponse
     */
    public function show_harga_bbm(Request $request)
    {
        $hargabbm = HargaBbm::find(1);
        $total_harga = $request->input('jumlah_liter') * $hargabbm->harga_perliter;
        return response()->json(['total_bbm' => $total_harga], 200);
    }

    /**
     * ambil data golongan berdasarkan pangkat
     * @param Request $request
     * @return JsonResponse
     */
    public function show_golongan_by_pangkat(Request $request)
    {
        $pangkat = Pangkat::where('nama_pangkat', $request->input('pangkat'))->first();
        return response()->json(['golongan' => $pangkat['golongan']], 200);
    }
}
