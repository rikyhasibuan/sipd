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
    <title>Daftar Personil</title>
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
                <h3 class="text-center">DAFTAR PERSONIL</h3>
                <h4 class="text-center">{!! $dinasboptim->dinasbop->kegiatan->nama_kegiatan !!}</h4>
                <h4 class="text-center">Tanggal {!! Carbon\Carbon::parse($dinasboptim->dinasbop->dari)->formatLocalized('%d %B %Y') !!} s.d. {!! Carbon\Carbon::parse($dinasboptim->dinasbop->sampai)->formatLocalized('%d %B %Y') !!}</h4>
                <div style="margin-top:15px;"></div>
                
                <div style="padding-left:1cm;padding-right:1cm;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:2%;text-align:center;">No</th>
                                <th style="width:15%;text-align:center;">Auditan</th>
                                <th style="width:15%;text-align:center;">Personil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;vertical-align:middle;">
                                   1
                                </td>
                                <td style="text-align: center;vertical-align:middle;">
                                    {!! $dinasboptim->auditan !!}
                                    <br>
                                    Nomor : <b>{!! $dinasboptim->nomor_sp !!}</b>
                                    <br>
                                    Tanggal : {!! Carbon\Carbon::parse($dinasboptim->tgl_sp)->formatLocalized('%d %B %Y') !!}
                                </td>
                                <td>
                                    <b>Wakil Penanggungjawab</b>
                                    <br>
                                    {!! $dinasboptim->tim['wakilpenanggungjawab']['nama'] !!}
                                    <br><br>
                                    <b>Pengendali Teknis</b>
                                    <br>
                                    {!! $dinasboptim->tim['pengendaliteknis']['nama'] !!}
                                    <br><br>
                                    <b>Ketua Tim</b>
                                    <br>
                                    {!! $dinasboptim->tim['ketuatim']['nama'] !!}
                                    <br><br>
                                    <b>Anggota Tim</b>
                                    <ol>
                                        @foreach($dinasboptim->tim['anggota'] as $y)
                                            <li>{!! $y['nama'] !!}</li>
                                        @endforeach
                                    </ol>
                                    <b>Pengemudi</b>
                                    <br>
                                    {!! $dinasboptim->tim['driver']['nama'] !!}
                                </td>
                            </tr>
                        </tbody>
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
                                <br>
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