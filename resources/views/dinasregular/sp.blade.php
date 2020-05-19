<?php
use App\Libraries\Common;
use App\Libraries\TimDinas;
$common = new Common();
$timdinas = new TimDinas();
$kpa = $timdinas->get_sekretaris();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Perintah</title>
    <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
    <style>
        @page  {
            size: auto;
        }
        body {
            margin: 0px;
        }

        * {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        h4 {
            font-size: 14pt;
        }
    </style>
</head>
<body onload="window.print()">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div style="text-align:center;"><img src="{!! asset('img/kop.png') !!}" style="width:100%;"></div>
            <h3 class="text-center">SURAT PERINTAH</h3>
            <h4 class="text-center">No. {!! $dinasregular->nomor_sp !!}</h4>
            <div style="margin-top:5px;"></div>
            <div style="padding-left:1cm;padding-right:1cm;">
                <table style="width:100%;">
                    <tr>
                        <td width="10%" style="text-align: left; vertical-align:text-top;">Dasar</td>
                        <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                        <td width="80%" style="text-align: justify; vertical-align:text-top;">
                            @if (count($dinasregular->dasar) > 1)
                                <ol style="margin-left: -25px;">
                                    @foreach ( $dinasregular->dasar as $dasar)
                                        <li>{!! $dasar !!}</li>
                                    @endforeach
                                </ol>
                            @else
                                {!! $dinasregular->dasar[0]; !!}
                            @endif
                        </td>
                    </tr>
                </table>

                <div style="margin-top:5px;"></div>
                <h4 class="text-center">MEMERINTAHKAN :</h4>
                <div style="margin-top:5px;"></div>
                <table style="width:100%;">
                    <tr>
                        <td width="10%" style="text-align: left; vertical-align:text-top;">Kepada</td>
                        <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                        <td width="80%" style="text-align: justify;">
                            <?php $i = 1; ?>
                            @foreach($dinasregular->tim as $anggota)
                                <span style="margin-right:20px;">{!! $i !!}.</span>
                                <span style="margin-right:85px;">Nama</span>
                                <span style="margin-right:10px;">:</span>
                                <span style="margin-right:20px;">{!! $anggota['nama'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:5px;">Pangkat/Golongan</span>
                                <span style="margin-right:10px;">:</span>
                                <span style="margin-right:20px;">{!! $anggota['pangkat'] !!} {!! $anggota['golongan'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:98px;">NIP</span>
                                <span style="margin-right:10px;">:</span>
                                <span style="margin-right:20px;">{!! $anggota['nip'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:76px;">Jabatan</span>
                                <span style="margin-right:10px;">:</span>
                                <span style="margin-right:20px;">{!! $anggota['jabatan'] !!}</span>
                                <br><br>
                                <?php $i++; ?>
                            @endforeach
                        </td>
                    </tr>
                </table>

                <div style="margin-top:5px;"></div>
                <table cellpadding="5" cellspacing="5" style="width:100%;">
                    <tr>
                        <td width="10%" style="text-align:left; vertical-align:text-top;">Untuk</td>
                        <td width="5%" style="text-align:center; vertical-align:text-top;">:</td>
                        <td width="80%" style="text-align:justify; vertical-align:text-top;">
                            @if(count($dinasregular->untuk) > 1)
                                <ol style="margin-left: -25px;">
                                    @foreach ( $dinasregular->untuk as $untuk)
                                        <li>{!! $untuk !!}</li>
                                    @endforeach
                                </ol>
                            @else
                                {!! $dinasregular->untuk[0] !!}
                            @endif
                        </td>
                    </tr>
                </table>

                <div style="margin-top:5px;"></div>
                <table style="width:100%;">
                    <tr>
                        <td width="10%" style="text-align: left; vertical-align:text-top;">Waktu</td>
                        <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                        <td width="80%" style="text-align: justify; vertical-align:text-top;">
                            Mulai tanggal {!! $common->generate_indonesia_date($dinasregular->dari) !!}
                            sampai {!! $common->generate_indonesia_date($dinasregular->sampai) !!}
                        </td>
                    </tr>
                </table>
                <div style="margin-top:5px;"></div>
                <table width="100%">
                    <tr>
                        <td width="50%"></td>
                        <td width="30%">
                            <table cellpadding="2" cellspacing="2" style="width:100%;">
                                <tr>
                                    <td width="10%" style="text-align: justify;">Ditetapkan di</td>
                                    <td width="10%" style="text-align: right;">Bandung</td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: justify;">Pada Tanggal</td>
                                    <td width="10%" style="text-align: right;">{!! $common->generate_indonesia_date($dinasregular->tgl_sp) !!}</td>
                                </tr>
                            </table>
                            <br>
                            <table style="width:100%;">
                                <tr>
                                    <td width="30%" style="text-align: center;"><b>an. INSPEKTUR PROVINSI JAWA BARAT<br>Sekretaris,</b></td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: center;"><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: center;">{!! $kpa['nama'] !!}</td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: center;">{!! $kpa['pangkat'] !!}</td>
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
</div>
</body>
</html>
