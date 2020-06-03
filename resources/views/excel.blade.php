<?php
use App\Libraries\Common;
$common = new Common();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>LAPORAN PENYERAPAN ANGGARAN PERJALANAN DINAS</title>
</head>
<body>
<table>
    <tr>
        <td colspan="7"><h1><b>LAPORAN PENYERAPAN ANGGARAN PERJALANAN DINAS</b></h1></td>
    </tr>
    <tr>
        <td colspan="7"><h1><b>PER TRANSAKSI KEGIATAN</b></h1></td>
    </tr>
    <tr>
        <td colspan="7">
            @if ($dari == $sampai)
                <h2><b>PERIODE {{ strtoupper($common->generate_indonesia_month(ltrim($dari, '0'))) }} {{ $tahun }}</b></h2>
            @else
                <h2><b>PERIODE {{ strtoupper($common->generate_indonesia_month(ltrim($dari, '0'))) }}  S/D {{ strtoupper($common->generate_indonesia_month(ltrim($sampai,'0'))) }} {{ $tahun }}</b></h2>
            @endif
        </td>
    </tr>
</table>
<table cellborder="1" width="100%">
    <thead>
        <tr>
            <th width="5%"><b>No</b></th>
            <th width="15%"><b>Bendahara</b></th>
            <th width="25%"><b>Kegiatan</b></th>
            <th width="25%"><b>Belanja</b></th>
            <th width="15%"><b>Pagu Anggaran</b></th>
            <th width="15%"><b>Realisasi Anggaran</b></th>
            <th width="5%"><b>Sisa Anggaran</b></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        @foreach($data as $row)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row['bendahara'] }}</td>
                <td>{{ $row['kegiatan'] }}</td>
                <td>{{ $row['belanja'] }}</td>
                <td>{{ $row['anggaran'] }}</td>
                <td>{{ $row['serapan'] }}</td>
                <td>{{ $row['sisa'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
