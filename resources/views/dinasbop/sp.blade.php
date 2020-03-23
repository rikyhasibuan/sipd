<?php 
use App\Libraries\TimDinas;
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
    <style>
        @page  { 
            size: auto;
            margin: 2.54cm 2.54cm 25cm 25cm;  
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
                <h4 class="text-center">No. {!! $dinasboptim->nomor_sp !!}</h4>
                <div style="margin-top:15px;"></div>
                <div style="padding-left:1cm;padding-right:1cm;">
                    <table cellpadding="5" cellspacing="5" style="width:100%;">
                        <tr>
                            <td width="10%" style="text-align: left; vertical-align:text-top;">Dasar</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <ol>
                                    @foreach ( $dinasboptim->dinasbop->dasar as $dasar)
                                        <li>{!! $dasar !!}</li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:20px;"></div>
                    <h4 class="text-center">MEMERINTAHKAN :</h4>

                    <div style="margin-top:20px;"></div>
                    <table cellpadding="5" cellspacing="5" style="width:100%;">
                        <tr>
                            <td width="10%" style="text-align: left; vertical-align:text-top;">Kepada</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify;">
                                <span style="margin-right:20px;">1.</span>
                                <span style="margin-right:50px;">Nama</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">{!! $dinasboptim->tim['wakilpenanggungjawab']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:40px;">Jabatan</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">Wakil Penanggung Jawab</span>
                                <br><br>

                                <span style="margin-right:20px;">2.</span>
                                <span style="margin-right:50px;">Nama</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">{!! $dinasboptim->tim['pengendaliteknis']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:40px;">Jabatan</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">Pengendali Teknis</span>
                                <br><br>

                                <span style="margin-right:20px;">3.</span>
                                <span style="margin-right:50px;">Nama</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">{!! $dinasboptim->tim['ketuatim']['nama'] !!}</span>
                                <br>
                                <span style="margin-right:35px;"></span>
                                <span style="margin-right:40px;">Jabatan</span>
                                <span style="margin-right:30px;">:</span>
                                <span style="margin-right:20px;">Ketua Tim</span>
                                <br><br>
                                
                                <?php $i = 4; ?>
                                @foreach($dinasboptim->tim['anggota'] as $anggota)
                                    <span style="margin-right:20px;">{!! $i !!}.</span>
                                    <span style="margin-right:50px;">Nama</span>
                                    <span style="margin-right:30px;">:</span>
                                    <span style="margin-right:20px;">{!! $anggota['nama'] !!}</span>
                                    <br>
                                    <span style="margin-right:35px;"></span>
                                    <span style="margin-right:40px;">Jabatan</span>
                                    <span style="margin-right:30px;">:</span>
                                    <span style="margin-right:20px;">Anggota</span>
                                    <br><br>
                                    <?php $i++; ?>
                                @endforeach
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:20px;"></div>
                    <table cellpadding="5" cellspacing="5" style="width:100%;">
                        <tr>
                            <td width="10%" style="text-align: left; vertical-align:text-top;">Untuk</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                <table cellpadding="5" cellspacing="5" style="width:100%;table-layout: fixed;">
                                    <tr>
                                        <td width="3%" style="text-align: left; vertical-align:text-top;">1.</td>
                                        <td width="95%" style="text-align: justify; vertical-align:text-top;">
                                            {!! $dinasboptim->auditan !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: left; vertical-align:text-top;">2.</td>
                                        <td width="70%" style="text-align: justify; vertical-align:text-top;">
                                            Menyusun Program Kerja Pemeriksaan (PKP)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align: left; vertical-align:text-top;">3.</td>
                                        <td width="70%" style="text-align: justify; vertical-align:text-top;">
                                            melaporkan hasilnya kepada Inspektur Provinsi Jawa Barat.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:20px;"></div>
                    <table cellpadding="5" cellspacing="5" style="width:100%;">
                        <tr>
                            <td width="10%" style="text-align: left; vertical-align:text-top;">Waktu</td>
                            <td width="5%" style="text-align: center; vertical-align:text-top;">:</td>
                            <td width="80%" style="text-align: justify; vertical-align:text-top;">
                                Mulai tanggal {!! Carbon\Carbon::parse($dinasboptim->dinasbop->dari)->formatLocalized('%d %B %Y') !!} 
                                sampai {!! Carbon\Carbon::parse($dinasboptim->dinasbop->sampai)->formatLocalized('%d %B %Y') !!}
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:20px;"></div>
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