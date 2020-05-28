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
<title>Surat Perjalanan Dinas</title>
<link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/print.css') !!}">
<style type="text/css" media="print">
    @page {
        size: auto;
        margin-top: 0.1in;
        margin-bottom: 0.1in;
        margin-left: 0.1in;
        margin-right: 0.1in;
    }

    .table-print td {
        border: none !important;
        padding: 5px;
    }
</style>
<style type="text/css">
    body {
        margin: 0px;
    }

    * {
        font-family: 'Bookman Old Style', Times, serif;
        font-size: 6pt;
    }

    h4 {
        font-size: 9pt;
    }

    .table-bordered td, .table-bordered th {
        border: 1px solid #333 !important;
    }

    .table td, .table th {
        padding: .25rem !important;
    }

    .table-print td {
        border: none !important;
        padding: 5px;
    }


</style>
</head>

<body onload="window.print()">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-6">
						<div style="text-align: center;margin-top:5px;">
							<img src="{!! asset('img/kop.png') !!}" style="width: 95%;">
						</div>
						<table style="width: 100%;">
							<tr>
								<td width="50%"></td>
								<td width="10%" style="text-align: right;">Lembar Ke :</td>
								<td width="15%"></td>
							</tr>
							<tr>
								<td width="50%"></td>
								<td width="10%" style="text-align: right;">Kode No :</td>
								<td width="15%"></td>
							</tr>
							<tr>
								<td width="50%"></td>
								<td width="10%" style="text-align: right;">Nomor :</td>
								<td width="15%"></td>
							</tr>
						</table>
						<div style="margin-top: 15px;"></div>
						<strong><u><h4 class="text-center">SURAT PERJALANAN DINAS (SPD)</h4></u></strong>
						<div style="margin-top: 15px;"></div>
						<div>
							<table class="table table-bordered" style="width: 100%;">
								<tr>
									<td width="3%" style="text-align: center;">1</td>
									<td width="35%">Kuasa Pengguna Anggaran</td>
									<td width="60%" colspan="2">{!! $kpa['nama'] !!}</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">2</td>
									<td width="35%">Nama / NIP Pegawai yang melaksanakan perjalanan</td>
									<td width="60%" colspan="2">
										{!! $dinasregular->tim[0]['nama'] !!}<br>
										{!! $dinasregular->tim[0]['nip'] !!}
									</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">3</td>
									<td width="35%">a. Pangkat dan Golongan<br> b. Jabatan<br> c.
										Tingkat Biaya Perjalanan Dinas
									</td>
									<td width="60%" colspan="2">
										{!! $dinasregular->tim[0]['pangkat'] !!} {!! $dinasregular->tim[0]['golongan'] !!}<br>
										{!! $dinasregular->tim[0]['jabatan'] !!}<br>
									</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">4</td>
									<td width="35%">Maksud Perjalanan Dinas</td>
									<td width="60%" colspan="2">{!! $dinasregular->untuk[0] !!}</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">5</td>
									<td width="35%">Alat Angkutan / transportasi yang digunakan</td>
									<td width="60%" colspan="2"></td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">6</td>
									<td width="35%">a. Tempat berangkat<br> b. Tempat tujuan
									</td>
									<td width="60%" colspan="2">Kota Bandung<br> {!! $dinasregular->auditan !!}
									</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">7</td>
									<td width="35%">a. Lamanya Perjalanan Dinas<br> b. Tanggal
										berangkat<br> c. Tanggal harus kembali / tiba di tempat baru *)
									</td>
									<td width="60%" colspan="2">
										{!! $durasi !!} ({!! $common->terbilang($durasi)!!}) hari<br>
										{!! $common->generate_indonesia_date($dinasregular->dari) !!} <br>
										{!! $common->generate_indonesia_date($dinasregular->sampai) !!}
									</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">8</td>
									<td width="30%">Pengikut : Nama</td>
									<td width="30%" style="text-align: center;">Tanggal Lahir</td>
									<td width="30%" style="text-align: center;">Keterangan</td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;"></td>
									<td width="30%">
										<ol style="margin-left: -15%;">
											@for($i = 1; $i < count($dinasregular->tim); $i++)
												<li>{!! $dinasregular->tim[$i]['nama'] !!}</li>
											@endfor
										</ol>
									</td>
									<td width="30%" style="text-align: center;"></td>
									<td width="30%" style="text-align: center;"></td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">9</td>
									<td width="30%">Pembebanan anggaran<br>
										<ol type="a" style="margin-left: -15%;">
											<li>Instansi</li>
											<li>Akun</li>
										</ol>
									</td>
									<td width="30%" style="text-align: center;"></td>
									<td width="30%" style="text-align: center;"></td>
								</tr>
								<tr>
									<td width="3%" style="text-align: center;">10</td>
									<td width="30%">Keterangan lain-lain</td>
									<td width="60%" colspan="2"></td>
								</tr>
                            </table>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width:70%;border:0px !important;vertical-align: top;">
                                        *) coret yang tidak perlu
                                    </td>
                                    <td style="border:0px !important;"></td>
                                    <td width="60%" colspan="2" style="border:0px !important;">
                                        <table class="table-print" style="width: 100%;">
                                            <tr>
                                                <td width="10%" style="text-align: justify;">Dikeluarkan di</td>
                                                <td width="10%" style="text-align: right;">Bandung</td>
                                            </tr>
                                            <tr>
                                                <td width="10%" style="text-align: justify;">Tanggal</td>
                                                <td width="10%" style="text-align: right;">{!!
													$common->generate_indonesia_date($dinasregular->tgl_sp) !!}</td>
                                            </tr>
                                        </table>
                                        <table class="table-print" style="width: 100%;">
                                            <tr>
                                                <td width="25%" style="text-align: center;"><b>Kuasa Pengguna Anggaran</b></td>
                                            </tr>
                                            <tr>
                                                <td width="10%" style="text-align: center;"><br> <br> <br> <br></td>
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
						<div style="margin-bottom: 5px;"></div>
						</div>
					</div>
					<div class="col-md-6">
						<br><br>
						<table class="table table-bordered">
							<tr>
								<td style="width:50%;">
									<table class="table-print">
										<tr>
											<td>I.</td>
										</tr>
									</table>
								</td>
								<td style="width:50%;">
									<table class="table-print">
										<tr>
                                            <td style="width:60%;">Berangkat dari</td>
                                            <td>: Kota Bandung</td>
										</tr>
										<tr>
                                            <td style="width:60%;">(Tempat Kedudukan)</td>
                                            <td></td>
										</tr>
										<tr>
                                            <td style="width:60%;">Pada Tanggal</td>
                                            <td>: {!! $common->generate_indonesia_date($dinasregular->dari) !!}</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<table class="table-print">
										<tr>
                                            <td style="width:2%;">II.</td>
                                            <td style="width:25%;">Tiba di</td>
                                            <td>: {!! $dinasregular->auditan !!}</td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Pada Tanggal</td>
                                            <td>: {!! $common->generate_indonesia_date($dinasregular->dari) !!}</td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Kepala</td>
                                            <td>:<br><br><br><br><br><br></td>
										</tr>
									</table>
								</td>
								<td style="width:50%;">
									<table class="table-print">
										<tr>
                                            <td style="width:60%;">Berangkat dari<br>Ke</td>
                                            <td>
                                                : {!! $dinasregular->auditan !!}<br>
                                                : Kota Bandung
                                            </td>
										</tr>
										<tr>
                                            <td style="width:60%;">Pada Tanggal</td>
                                            <td>: {!! $common->generate_indonesia_date($dinasregular->sampai) !!}</td>
										</tr>
										<tr>
                                            <td style="width:60%;">Kepala</td>
                                            <td>:</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<table class="table-print">
										<tr>
                                            <td style="width:2%;">III.</td>
                                            <td style="width:25%;">Tiba di</td>
                                            <td>: </td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Pada Tanggal</td>
                                            <td>: </td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Kepala</td>
                                            <td>:<br><br><br><br><br><br></td>
										</tr>
									</table>
									<br><br>
								</td>
                                <td style="width:50%;">
                                    <table class="table-print">
                                        <tr>
                                            <td style="width:60%;">Berangkat dari<br>Ke</td>
                                            <td>
                                                : <br>
                                                :
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:60%;">Pada Tanggal</td>
                                            <td>: </td>
                                        </tr>
                                        <tr>
                                            <td style="width:60%;">Kepala</td>
                                            <td>:</td>
                                        </tr>
                                    </table>
                                    <br><br>
                                </td>
							</tr>
                            <tr>
                                <td style="width:50%;">
                                    <table class="table-print">
                                        <tr>
                                            <td style="width:2%;">IV.</td>
                                            <td style="width:25%;">Tiba di</td>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Pada Tanggal</td>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Kepala</td>
                                            <td>:<br><br><br><br><br><br></td>
                                        </tr>
                                    </table>
                                    <br><br>
                                </td>
                                <td style="width:50%;">
                                    <table class="table-print">
                                        <tr>
                                            <td style="width:60%;">Berangkat dari<br>Ke</td>
                                            <td>
                                                : <br>
                                                :
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:60%;">Pada Tanggal</td>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <td style="width:60%;">Kepala</td>
                                            <td>:</td>
                                        </tr>
                                    </table>
                                    <br><br>
                                </td>
                            </tr>
							<tr>
								<td colspan="2">
									<table class="table-print">
										<tr>
                                            <td style="width:2%;">V.</td>
                                            <td style="width:25%;">Tiba kembali di </td>
                                            <td>: Kota Bandung</td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td style="width:25%;">Pada Tanggal</td>
                                            <td>: {!! $common->generate_indonesia_date($dinasregular->sampai) !!}</td>
										</tr>
										<tr>
                                            <td style="width:2%;"></td>
                                            <td colspan="2">
                                                Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan
                                                jabatan dalam kurun waktu yang sesingkat-singkatnya.
                                            </td>
										</tr>
										<tr>
											<td>
											</td>
											<td></td>
											<td>
                                                <div style="margin-top:18px;"></div>
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td width="25%" style="text-align: center;"><b>Kuasa Pengguna Anggaran</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%" style="text-align: center;"><br> <br><br><br></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%" style="text-align: center;">{!! $kpa['nama'] !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%" style="text-align: center;">NIP. {!! $kpa['nip'] !!}</td>
                                                    </tr>
                                                </table>
											</td>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table class="table-print">
										<tr>
                                            <td>VI. PERHATIAN</td>
										</tr>
										<tr>
                                            <td>
                                                PA/KPA yang menertibkan SPD, pegawai yang melakukan perjalanan dinas, pada pejabat yang mengesahkan tanggal
                                                berangkat / tiba, serta bendahara pengeluaran yang bertanggung jawab berdasarkan peraturan-peraturan Keuangan
                                                Negawa menderita rugi akbitan kesalahan, kelalaian dan kealpaannya.
                                            </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
