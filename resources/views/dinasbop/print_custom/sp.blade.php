<?php
use App\Libraries\TimDinas;
use App\Libraries\Common;
$common = new Common();
$timdinas = new TimDinas();
$inspektur = $timdinas->get_inspektur();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Perintah</title>
    <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/print.css') !!}">
    <style>
        * {
            font-family: "Bookman Old Style";
            font-size: 12pt;
        }

        @media print {
            @page {
                size:auto;
            }
            body {
                margin: 0px;
            }

            * {
                font-family: "Bookman Old Style";
                font-size: 12pt;
            }

            h4 {
                font-size: 14pt;
            }

            .table td {
                padding: 1.5px !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div style="text-align:center;"><img src="{!! asset('img/kop.png') !!}" style="width:100%;"></div>
                <h3 class="text-center">SURAT PERINTAH</h3>
                <h4 class="text-center">No. {!! $dinasbopcustom->nomor_sp !!}</h4>
                <div style="margin-top:15px;"></div>
                <div style="padding-left:0.5cm;padding-right:0.5cm;">
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="5%" style="text-align: left; vertical-align:text-top;">Dasar</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <table cellpadding="2" cellspacing="2" style="width:100%;table-layout:fixed;">
                                    @if(count($dinasbopcustom->dinasbop->dasar) > 1)
                                        <?php $n = 0; ?>
                                        @foreach($dinasbopcustom->dinasbop->dasar as $v)
                                            <tr>
                                                <td width="3%" style="text-align: left; vertical-align:text-top;">{!! ++$n !!}.</td>
                                                <td width="95%" style="text-align: justify; vertical-align:text-top;">
                                                    {!! $v !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td width="100%" style="text-align: justify; vertical-align:text-top;">
                                                {!! $dinasbopcustom->dinasbop->dasar[0] !!}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:10px;"></div>
                    <h4 class="text-center">MEMERINTAHKAN :</h4>
                    <div style="margin-top:20px;"></div>
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="5%" style="text-align:left; vertical-align:text-top;">Kepada</td>
                            <td width="5%" style="text-align:center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align:justify;">
                                <span style="margin-right:1rem;">1.</span>
                                <span style="margin-right:3rem;">Nama</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['penanggungjawab']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:4.1rem;">NIP</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['penanggungjawab']['nip'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:1.8rem;">Jabatan</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>Penanggung Jawab</span>
                                <br><br>
                                <span style="margin-right:1rem;">2.</span>
                                <span style="margin-right:3rem;">Nama</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['wakilpenanggungjawab']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:4.1rem;">NIP</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['wakilpenanggungjawab']['nip'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:1.8rem;">Jabatan</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>Wakil Penanggung Jawab</span>
                                <br><br>

                                <span style="margin-right:1rem;">3.</span>
                                <span style="margin-right:3rem;">Nama</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['pengendaliteknis']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:4.1rem;">NIP</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['pengendaliteknis']['nip'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:1.8rem;">Jabatan</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>Pengendali Teknis</span>
                                <br><br>

                                <span style="margin-right:1rem;">4.</span>
                                <span style="margin-right:3rem;">Nama</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['ketuatim']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:4.1rem;">NIP</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>{!! $dinasbopcustom->tim['ketuatim']['nip'] !!}</span>
                                <br>
                                <span style="margin-right:2.3rem;"></span>
                                <span style="margin-right:1.8rem;">Jabatan</span>
                                <span style="margin-right:2rem;">:</span>
                                <span>Ketua Tim</span>
                                <br><br>

                                <?php $i = 5; ?>
                                @foreach($dinasbopcustom->tim['anggota'] as $anggota)
                                    <span style="margin-right:1rem;">{!! $i !!}.</span>
                                    <span style="margin-right:3rem;">Nama</span>
                                    <span style="margin-right:2rem;">:</span>
                                    <span>{!! $anggota['nama'] !!}</span>
                                    <br>
                                    <span style="margin-right:2.3rem;"></span>
                                    <span style="margin-right:4.1rem;">NIP</span>
                                    <span style="margin-right:2rem;">:</span>
                                    <span>{!! $anggota['nip'] !!}</span>
                                    <br>
                                    <span style="margin-right:2.3rem;"></span>
                                    <span style="margin-right:1.8rem;">Jabatan</span>
                                    <span style="margin-right:2rem;">:</span>
                                    <span>Anggota</span>
                                    <br><br>
                                    <?php $i++; ?>
                                @endforeach
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:5px;"></div>
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="5%" style="text-align: left; vertical-align:text-top;">Untuk</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <table cellpadding="2" cellspacing="2" style="width:100%;table-layout:fixed;">
                                    @if(count($dinasbopcustom->dinasbop->untuk) > 1)
                                        <?php $n = 0; ?>
                                        @foreach($dinasbopcustom->dinasbop->untuk as $v)
                                            <tr>
                                                <td width="3%" style="text-align: left; vertical-align:text-top;">{!! ++$n !!}.</td>
                                                <td width="95%" style="text-align: justify; vertical-align:text-top;">
                                                    {!! $v !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td width="95%" style="text-align: justify; vertical-align:text-top;">
                                                {!! $dinasbopcustom->dinasbop->untuk[0] !!}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:5px;"></div>
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="5%" style="text-align: left; vertical-align:text-top;">Waktu</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                Mulai tanggal {!! $common->generate_indonesia_date($dinasbopcustom->dinasbop->dari) !!}
                                sampai {!! $common->generate_indonesia_date($dinasbopcustom->dinasbop->sampai) !!}
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:5px;"></div>
                    <table width="100%">
                        <tr>
                            <td width="50%"></td>
                            <td width="25%">
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="10%" style="text-align: justify;">Ditetapkan di</td>
                                        <td width="10%" style="text-align: right;">Bandung</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: justify;">Pada Tanggal</td>
                                        <td width="10%" style="text-align: right;">{!! $common->generate_indonesia_date($dinasbopcustom->tgl_sp) !!}</td>
                                    </tr>
                                </table>
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="20%" style="text-align: center;"><b>INSPEKTUR PROVINSI JAWA BARAT</b></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;"><br><br><br><br></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">{!! $inspektur['nama'] !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">{!! $inspektur['pangkat'] !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: center;">NIP. {!! $inspektur['nip'] !!}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
