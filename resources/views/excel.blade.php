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
<table cellspacing="5" cellpadding="5" cellborder="1">
    <thead>
    <tr>
        <th><b>No</b></th>
        <th><b>Bendahara</b></th>
        <th><b>Kegiatan</b></th>
        <th><b>Jumlah Anggaran Tersedia</b></th>
        <th><b>Penyerapan Anggaran</b></th>
        <th><b>Sisa Anggaran</b></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    @foreach($data as $row)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $row['bendahara'] }}</td>
            <td>{{ $row['kegiatan'] }}</td>
            <td>{{ $common->rupiah($row['anggaran']) }}</td>
            <td>{{ $common->rupiah($row['serapan']) }}</td>
            <td>{{ $common->rupiah($row['sisa']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
