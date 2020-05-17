<?php
use App\Libraries\Common;
use App\Libraries\TimDinas;
$common = new Common();
$timdinas = new TimDinas();
$diff = date_diff(date_create($timpengumpuldata->dinasboppengumpuldata->dari), date_create($timpengumpuldata->dinasboppengumpuldata->sampai));
$durasi = $diff->days + 1;
$kpa = $timdinas->get_sekretaris();
$total = $timpengumpuldata->dinasboppengumpuldata->total_anggaran;
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
				<div class="col-md-12">
					<div style="text-align:center;"><img src="{!! asset('img/kop.png') !!}" style="width:100%;"></div>
					<strong><u><h4 class="text-center">RINCIAN BIAYA PERJALANAN DINAS</h4></u></strong>
					<br>
					<center>
						<table width="100%">
							<tr>
								<td style="width:5%;"></td>
								<td style="width:20%;"></td>
								<td style="width:2%;">Nomor BKU</td>
								<td style="width:20%;">:</td>
							</tr>
							<tr>
								<td style="width:5%;">Lampiran SPD Nomor</td>
								<td style="width:20%;">: {!! $timpengumpuldata->nomor_sp !!}</td>
								<td style="width:2%;">Tanggal BKU</td>
								<td style="width:20%;">: </td>
							</tr>
							<tr>
								<td style="width:5%;">Tanggal</td>
								<td style="width:20%;">: {!! $common->generate_indonesia_date($timpengumpuldata->tgl_sp) !!}</td>
								<td style="width:2%;">Kodering</td>
								<td style="width:20%;">: {!! $timpengumpuldata->dinasboppengumpuldata->dinasbop->belanja->kode_belanja !!}</td>
							</tr>
						</table>
					</center>
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
										Perjalanan Dinas {!! $timpengumpuldata->dinasboppengumpuldata->dinasbop->kegiatan->nama_kegiatan !!}, selama {!! $durasi !!} hari dari tanggal {!! $common->generate_indonesia_date($timpengumpuldata->dinasboppengumpuldata->dari) !!}
										s.d {!! $common->generate_indonesia_date($timpengumpuldata->dinasboppengumpuldata->sampai) !!}.
								</td>
							</tr>
							<tr>
								<td style="text-align: center;">1</td>
								<td><b>Biaya Operasional Inspektorat</b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td style="text-align: center;"></td>
								<td>
									<table width="100%" class="table-print table table-borderless">
										<tr>
											<td style="width:20%;vertical-align:middle;">{!! $timpengumpuldata->tim['wakilpenanggungjawab']['nama'] !!}</td>
											<td style="width:20%;text-align:center;vertical-align:middle;">Wakil Penanggung Jawab</td>
											<td style="width:15%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['wakilpenanggungjawab']['golongan'] !!}
											</td>
											<td style="width:4%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['wakilpenanggungjawab']['hari'] !!} hari
											</td>
											<td style="width:1%;text-align:center;vertical-align:middle;">x</td>
											<td style="width:10%;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['wakilpenanggungjawab']['biaya']) !!}
											</td>
										</tr>
										<tr>
											<td style="width:20%;vertical-align:middle;">{!! $timpengumpuldata->tim['pengendaliteknis']['nama'] !!}</td>
											<td style="width:20%;text-align:center;vertical-align:middle;">Pengendali Teknis</td>
											<td style="width:15%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['pengendaliteknis']['golongan'] !!}
											</td>
											<td style="width:4%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['pengendaliteknis']['hari'] !!} hari
											</td>
											<td style="width:1%;text-align:center;vertical-align:middle;">x</td>
											<td style="width:10%;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['pengendaliteknis']['biaya']) !!}
											</td>
										</tr>
										<tr>
											<td style="width:20%;vertical-align:middle;">{!! $timpengumpuldata->tim['ketuatim']['nama'] !!}</td>
											<td style="width:20%;text-align:center;vertical-align:middle;">Ketua Tim</td>
											<td style="width:15%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['ketuatim']['golongan'] !!}
											</td>
											<td style="width:4%;text-align:center;vertical-align:middle;">
												{!! $timpengumpuldata->tim['ketuatim']['hari'] !!} hari
											</td>
											<td style="width:1%;text-align:center;vertical-align:middle;">x</td>
											<td style="width:10%;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['ketuatim']['biaya']) !!}
											</td>
										</tr>
										@foreach($timpengumpuldata->tim['anggota'] as $v)
											<tr>
												<td style="width:20%;vertical-align:middle;">{!! $v['nama'] !!}</td>
												<td style="width:20%;text-align:center;vertical-align:middle;">Anggota</td>
												<td style="width:15%;text-align:center;vertical-align:middle;">{!! $v['golongan'] !!}</td>
												<td style="width:4%;text-align:center;vertical-align:middle;">{!! $v['hari'] !!} hari</td>
												<td style="width:1%;text-align:center;vertical-align:middle;">x</td>
												<td style="width:10%;vertical-align:middle;">Rp.{!! $common->rupiah($v['biaya']) !!}</td>
											</tr>
										@endforeach
									</table>
								</td>
								<td>
									<table width="100%" class="table-print table table-borderless">
										<tr>
											<td style="text-align:right;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['wakilpenanggungjawab']['total']) !!}
											</td>
										</tr>
										<tr>
											<td style="text-align:right;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['pengendaliteknis']['total']) !!}
											</td>
										</tr>
										<tr>
											<td style="text-align:right;vertical-align:middle;">
												Rp.{!! $common->rupiah($timpengumpuldata->tim['ketuatim']['total']) !!}
											</td>
										</tr>
										@foreach($timpengumpuldata->tim['anggota'] as $v)
											<tr>
												<td style="text-align:right;vertical-align:middle;">
													Rp.{!! $common->rupiah($v['total']) !!}
												</td>
											</tr>
										@endforeach
									</table>
								</td>
								<td style="vertical-align:middle; text-align:center;">
									<table width="100%" class="table-print table table-borderless">
										<tr><td style="text-align:center;vertical-align:middle;">Terlampir</td></tr>
										<tr><td style="text-align:center;vertical-align:middle;">Terlampir</td></tr>
										<tr><td style="text-align:center;vertical-align:middle;">Terlampir</td></tr>
										@foreach($timpengumpuldata->tim['anggota'] as $v)
											<tr><td style="text-align:center;vertical-align:middle;">Terlampir</td></tr>
										@endforeach
									</table>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;"></td>
								<td><b>Jumlah Biaya Operasional Inspektorat</b></td>
								<td style="text-align: right;vertical-align:middle;">
									<b>Rp.{!! $common->rupiah($timpengumpuldata->total_anggaran) !!}</b>
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
								<td style="text-align: center;"></td>
								<td><b>Jumlah akomodasi</b></td>
								<td style="text-align: right; vertical-align:middle;">
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
								<td><b>Jumlah transportasi</b></td>
								<td style="text-align: right;vertical-align:middle;"></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"><b>Jumlah Total</b></td>
								<td style="text-align: right; vertical-align:middle;"><b>Rp.{!! $common->rupiah(($timpengumpuldata->total_anggaran) ) !!}</b></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="4"><b><i>{!! $common->terbilang($timpengumpuldata->total_anggaran) !!} Rupiah</i></b></td>
							</tr>
						</tbody>
					</table>
					<table width="100%">
						<tr>
							<td width="25%"></td>
							<td width="25%">
								<center>
									<table cellpadding="2" cellspacing="2" style="width:30%;">
										<tr>
											<td width="10%" style="text-align: center;">
												Bandung, {!! $common->generate_indonesia_date($timpengumpuldata->tgl_sp) !!}
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
										<td width="20%" style="text-align: center;">Rp.{!! $common->rupiah($timpengumpuldata->total_anggaran) !!}</td>
									</tr>
									<tr>
										<td width="20%" style="text-align: center;"><b>Bendahara Pengeluaran Pembantu</b></td>
									</tr>
									<tr>
										<td width="10%" style="text-align: center;"><br><br><br></td>
									</tr>
									<tr>
										<td width="10%" style="text-align: center;">{!! $timpengumpuldata->dinasboppengumpuldata->dinasbop->kegiatan->pegawai->nama !!}</td>
									</tr>
									<tr>
										<td width="10%" style="text-align: center;">
											NIP. {!! $timpengumpuldata->dinasboppengumpuldata->dinasbop->kegiatan->pegawai->nip !!}
										</td>
									</tr>
								</table>
							</td>
							<td width="25%">
								<table cellpadding="2" cellspacing="2" style="width:100%;">
									<tr>
										<td width="20%" style="text-align: center;">
											Telah menerima jumlah uang sebesar
										</td>
									</tr>
									<tr>
										<td width="20%" style="text-align: center;">
											Rp.{!! $common->rupiah($timpengumpuldata->total_anggaran) !!}
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
											{!! $timpengumpuldata->tim['anggota'][0]['nama'] !!}
										</td>
									</tr>
									<tr>
										<td width="10%" style="text-align: center;">
											NIP. {!! $timpengumpuldata->tim['anggota'][0]['nip'] !!}
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br><br>
					<div class="col-lg-12">
						<hr style="border: 1px solid #000;">
						<div style="margin-top:20px;"></div>
						<span style="text-align:center;"><h4>PERHITUNGAN SPD RAMPUNG</h4></span>
						<table width="100%">
							<tr>
								<td width="90%">Ditetapkan sejumlah</td>
								<td width="10%" style="text-align:right;">Rp.{!! $common->rupiah(($timpengumpuldata->total_anggaran) ) !!}</td>
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
								<td width="5%" style="text-align:right;">Rp.{!! $common->rupiah(($timpengumpuldata->total_anggaran) ) !!}</td>
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
