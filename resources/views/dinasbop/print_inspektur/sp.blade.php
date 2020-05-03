<?php 
use App\Libraries\TimDinas;
$timdinas = new TimDinas();
$inspektur = $timdinas->get_sekretaris();
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
        @media print {
            @page  { 
                size: 'legal';
                margin-top: 0.5cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;  
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
                <h4 class="text-center">No. {!! $dinasbopinspektur->nomor_sp !!}</h4>
                <div style="margin-top:15px;"></div>
                <div style="padding-left:0.5cm;padding-right:0.5cm;">
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="7%" style="text-align: left; vertical-align:text-top;">Dasar</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <table cellpadding="2" cellspacing="2" style="width:100%;table-layout:fixed;">
                                    @if(count($dinasbopinspektur->dasar) > 1)
                                        <?php $n = 0; ?>
                                        @foreach($dinasbopinspektur->dasar as $v)
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
                                                {!! $dinasbopinspektur->dasar[0] !!}
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
                            <td width="7%" style="text-align: left; vertical-align:text-top;">Kepada</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify;">
                                <span style="margin-right:120px;">Nama</span>
                                <span style="margin-right:20px;">:</span>
                                <span style="margin-right:5px;">{!! $dinasbopinspektur->inspektur['nama'] !!}</span>
                                <br>
                                <span style="margin-right:31px;">Pangkat / Golongan </span>
                                <span style="margin-right:20px;">:</span>
                                <span style="margin-right:5px;">{!! $dinasbopinspektur->inspektur['pangkat'] !!} {!! $dinasbopinspektur->inspektur['golongan'] !!}</span>
                                <br>
                                <span style="margin-right:132px;">NIP </span>
                                <span style="margin-right:20px;">:</span>
                                <span style="margin-right:5px;">{!! $dinasbopinspektur->inspektur['nip'] !!}</span>
                                <br>
                                <span style="margin-right:110px;">Jabatan</span>
                                <span style="margin-right:20px;">:</span>
                                <span style="margin-right:5px;">Penanggungjawab</span>
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:5px;"></div>
                    <table cellpadding="2" cellspacing="2" style="width:100%;">
                        <tr>
                            <td width="7%" style="text-align: left; vertical-align:text-top;">Untuk</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <table cellpadding="2" cellspacing="2" style="width:100%;table-layout:fixed;">
                                    @if(count($dinasbopinspektur->tujuan) > 1)
                                        <?php $n = 0; ?>
                                        @foreach($dinasbopinspektur->tujuan as $v)
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
                                                {!! $dinasbopinspektur->tujuan[0] !!}
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
                            <td width="7%" style="text-align: left; vertical-align:text-top;">Waktu</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                Mulai tanggal {!! Carbon\Carbon::parse($dinasbopinspektur->dari)->formatLocalized('%d %B %Y') !!} 
                                sampai {!! Carbon\Carbon::parse($dinasbopinspektur->sampai)->formatLocalized('%d %B %Y') !!}
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
                                        <td width="10%" style="text-align: right;">{!! Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y') !!}</td>
                                    </tr>
                                </table>
                                <table cellpadding="2" cellspacing="2" style="width:100%;">
                                    <tr>
                                        <td width="20%" style="text-align: center;">Plh <b>SEKRETARIS DAERAH PROVINSI JAWA BARAT</b></td>
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