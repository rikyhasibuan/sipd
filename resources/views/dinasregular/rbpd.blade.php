<?php
use App\Libraries\Common;
use App\Libraries\TimDinas;
$common = new Common();
$timdinas = new TimDinas();
$diff = date_diff($dinasregular->dari, $dinasregular->sampai);
$durasi = ($diff->days + 1);
$kpa = $timdinas->get_sekretaris();
$total = $dinasregular->total_harian + $dinasregular->total_akomodasi + $dinasregular->total_transportasi['total'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rincian Biaya Perjalanan Dinas</title>
        <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
        <style type="text/css">
            body {
                margin: 0px;
            }

            * {
                font-family: 'Times New Roman', Times, serif;
                font-size: 8pt;
            }

            h4 {
                font-size: 14pt;
            }

            .table td {
                padding: 5px;
            }

            .table-print td {
                border: none !important;
                padding: 5px;
            }

            @media print {
                @page {
                    size: "legal";
                }

                .table td {
                    padding: 5px;
                }

                .table-print td {
                    border: none !important;
                    padding: 5px;
                }
            }
        </style>
    </head>
    <body onload="window.print()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div style="text-align:center;"><img src="{!! asset('img/kop.png') !!}" style="width:100%;"></div>
                    <strong><u><h4 class="text-center">RINCIAN BIAYA PERJALANAN DINAS</h4></u></strong>
                    <br>
                    <div style="text-align: center;">
                        <table width="100%">
                            <tr>
                                <td style="width:5%;"></td>
                                <td style="width:20%;"></td>
                                <td style="width:2%;">Nomor BKU</td>
                                <td style="width:20%;">: </td>
                            </tr>
                            <tr>
                                <td style="width:5%;">Lampiran SPD Nomor</td>
                                <td style="width:20%;">: {!! $dinasregular->nomor_sp !!}</td>
                                <td style="width:2%;">Tanggal BKU</td>
                                <td style="width:20%;">: </td>
                            </tr>
                            <tr>
                                <td style="width:5%;">Tanggal</td>
                                <td style="width:20%;">: {!! $common->generate_indonesia_date($dinasregular->tgl_sp) !!}</td>
                                <td style="width:2%;">Kodering</td>
                                <td style="width:20%;">: {!! $dinasregular->belanja->kode_belanja !!}</td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="2%" style="text-align: center;vertical-align:middle;">No.</th>
                                <th width="60%" style="text-align:center;vertical-align:middle;">Perincian Biaya</th>
                                <th width="5%" style="text-align:center;vertical-align:middle;">Jumlah</th>
                                <th width="5%" style="text-align:center;vertical-align:middle;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;"></td>
                                <td colspan="3">
                                    Perjalanan Dinas {!! $dinasregular->kegiatan->nama_kegiatan !!}, selama {!! $durasi !!} hari dari tanggal {!! $common->generate_indonesia_date($dinasregular->dari) !!}
                                    s.d {!! $common->generate_indonesia_date($dinasregular->sampai) !!}.
								</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">1</td>
                                <td><b>Uang Harian</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"></td>
                                <td>
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                        <tr>
                                            <td style="width:20%;vertical-align:middle;">{!! $v['nama'] !!}</td>
                                            <td style="width:20%;text-align:center;vertical-align:middle;">{!! $v['jabatan'] !!}</td>
                                            <td style="width:15%;text-align:center;vertical-align:middle;">{!! $v['pangkat'] !!} {!! $v['golongan'] !!}</td>
                                            <td style="width:4%;text-align:center;vertical-align:middle;">{!! $v['hari'] !!} hari</td>
                                            <td style="width:1%;text-align:center;vertical-align:middle;">x</td>
                                            <td style="width:10%;vertical-align:middle;">Rp.{!! $common->rupiah($v['biaya_harian']) !!}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                        <tr>
                                            <td style="text-align:right;vertical-align:middle;">
                                                Rp.{!! $common->rupiah($v['total_harian']) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td style="vertical-align:middle; text-align:center;">
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                            <tr>
                                                <td style="text-align:center;vertical-align:middle;">Terlampir</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
														</tr>
														<tr>
                                <td style="text-align:center;"></td>
                                <td><b>Jumlah Uang Harian</b></td>
                                <td style="text-align: right;vertical-align:middle;">
                                    <b>Rp.{!! $common->rupiah($dinasregular->total_harian) !!}</b>
								</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">2</td>
                                <td><b>Akomodasi</b></td>
                                <td></td>
                                <td></td>
							</tr>
							<tr>
                                <td style="text-align:center;"></td>
                                <td>
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                        <tr>
                                            <td style="width:20%;vertical-align:middle;">{!! $v['nama'] !!}</td>
                                            <td style="width:20%;text-align:center;vertical-align:middle;">{!! $v['jabatan'] !!}</td>
                                            <td style="width:15%;text-align:center;vertical-align:middle;">{!! $v['pangkat'] !!} {!! $v['golongan'] !!}</td>
                                            <td style="width:5%;text-align:center;vertical-align:middle;">{!! $v['inap'] !!} hari</td>
                                            <td style="width:1%;text-align:center;vertical-align:middle;">x</td>
                                            <td style="width:10%;vertical-align:middle;">Rp.{!! $common->rupiah($v['biaya_akomodasi']) !!}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                        <tr>
                                            <td style="text-align: right;vertical-align:middle;">
                                                Rp.{!! $common->rupiah($v['total_akomodasi']) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <table width="100%" class="table-print table table-borderless">
                                        @foreach($dinasregular->tim as $v)
                                            <tr>
                                                <td style="text-align:center;vertical-align:middle;">Terlampir</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"></td>
                                <td><b>Jumlah akomodasi</b></td>
                                <td style="text-align: right; vertical-align:middle;">
                                    <b>Rp.{!! $common->rupiah($dinasregular->total_akomodasi) !!}</b>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="text-align:center;vertical-align:middle;">3</td>
                                <td><b>Transportasi</b></td>
                                <td></td>
                                <td></td>
							</tr>
							<tr>
                                <td style="text-align: center;"></td>
                                <td>{!! $dinasregular->total_transportasi['jenis'] !!}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"></td>
                                <td><b>Jumlah transportasi</b></td>
                                <td style="text-align: right;vertical-align:middle;">
                                    <b>Rp.{!! $common->rupiah($dinasregular->total_transportasi['total']) !!}</b>
                                </td>
                                <td></td>
							</tr>
                            <tr>
                                <td colspan="2"><b>Jumlah Total</b></td>
                                <td style="text-align: right; vertical-align:middle;"><b>Rp.{!! $common->rupiah(($total) ) !!}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4"><b><i>{!! $common->terbilang($total) !!} Rupiah</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="25%"></td>
                            <td width="25%">
                                <center>
                                    <table style="width:30%;">
                                        <tr>
                                            <td width="10%" style="text-align: center;">Bandung, {!!
                                                $common->generate_indonesia_date($dinasregular->tgl_sp) !!}
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="20%" style="text-align: center;">Telah dibayar sejumlah</td>
                                    </tr>
                                    <tr>
                                        <td width="20%" style="text-align: center;">Rp.{!!
                                            $common->rupiah($total) !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%" style="text-align: center;"><b>Bendahara Pengeluaran Pembantu</b></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;"><br><br><br></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">{!! $dinasregular->kegiatan->pegawai->nama !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">
                                            NIP. {!! $dinasregular->kegiatan->pegawai->nip !!}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="25%">
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="20%" style="text-align: center;">Telah menerima jumlah uang sebesar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%" style="text-align: center;">
                                        Rp.{!! $common->rupiah($total) !!}
                                    </td>
                                    </tr>
                                    <tr>
                                        <td width="20%" style="text-align: center;"><b>Yang Menerima</b></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;"><br><br><br></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">
                                            {!! $dinasregular->tim[0]['nama'] !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">
                                            NIP. {!! $dinasregular->tim[0]['nip'] !!}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="col-lg-12">
                        <hr style="border: 1px solid #000;">
                        <div style="margin-top:20px;"></div>
                        <span style="text-align:center;">
                            <h4>PERHITUNGAN SPD RAMPUNG</h4>
                        </span>
                        <table width="100%">
                            <tr>
                                <td width="90%">Ditetapkan sejumlah</td>
                                <td width="10%" style="text-align:right;">Rp.{!! $common->rupiah(($total) ) !!}</td>
                            </tr>
                            <tr>
                                <td width="90%">Yang telah dibayar semula</td>
                                <td width="10%" style="text-align:right;">
                                    Rp. -
                                    <hr style="border:0.1px solid #ccc;">
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">Sisa kurang/lebih</td>
                                <td width="5%" style="text-align:right;">Rp.{!! $common->rupiah(($total) ) !!}</td>
                            </tr>
                        </table>
                        <div style="margin-bottom:20px;"></div>
                        <hr style="border: 1px solid #000;">
                    </div>
                    <br><br>
                    <table width="100%">
                        <tr>
                            <td width="25%"></td>
                            <td width="25%">
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="20%" style="text-align: center;"><b>Kuasa Pengguna Anggaran</b></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;"><br><br><br></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">{!! $kpa['nama'] !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">NIP. {!! $kpa['nip'] !!}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
