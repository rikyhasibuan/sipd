<?php
use App\Libraries\Common;
use App\Libraries\TimDinas;
$common = new Common();
$timdinas = new TimDinas();
$diff = date_diff($dinasregular->dari, $dinasregular->sampai);
$durasi = ($diff->days + 1);
$total = $dinasregular->total_harian + $dinasregular->total_transportasi['total'];
$kpa = $timdinas->get_sekretaris();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Pembayaran Uang Harian & Transport</title>
<link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
<style type="text/css" media="print">
    @page {
			size: auto;
    }
</style>
<style type="text/css">
    body {
			margin: 0px;
    }

    * {
			font-family: 'Times New Roman', Times, serif;
			font-size: 9pt;
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
				<strong><u><h4 class="text-center">INSPEKTORAT DAERAH PROVINSI JAWA BARAT</h4></u></strong>
				<br>
					<table width="95%">
						<tr>
							<td style="width:2%;vertical-align: top;">DAFTAR</td>
							<td style="width:2%;vertical-align: top;">: </td>
							<td style="width:70%;vertical-align: top;text-align: justify;">PENERIMAAN UANG HARIAN DAN TRANSPORTASI UNTUK {!! strtoupper($dinasregular->belanja->nama_belanja) !!} SELAMA {!! $durasi !!} ({!! strtoupper($common->terbilang($durasi)) !!}) HARI MULAI TANGGAL {!! strtoupper(Carbon\Carbon::parse($dinasregular->dari)->formatLocalized('%d %B %Y')) !!} SAMPAI DENGAN {!! strtoupper(Carbon\Carbon::parse($dinasregular->sampai)->formatLocalized('%d %B %Y')) !!} UNTUK MELAKUKAN {!! strtoupper($dinasregular->program->nama_program) !!} PADA {!! strtoupper($dinasregular->auditan) !!}</td>
						</tr>
					</table>
				<br>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="2%" style="text-align: center;vertical-align:middle;">NO</th>
							<th width="20%" style="text-align:center;vertical-align:middle;">NAMA</th>
							<th width="15%" style="text-align:center;vertical-align:middle;">PANGKAT &nbsp; GOL</th>
							<th width="7%" style="text-align:center;vertical-align:middle;">UANG HARIAN</th>
							<th width="2%" style="text-align:center;vertical-align:middle;">UANG SAKU</th>
							<th width="2%" style="text-align:center;vertical-align:middle;">TRANSPORTASI</th>
							<th width="10%" style="text-align:center;vertical-align:middle;">JUMLAH YANG DITERIMA</th>
							<th width="10%" style="text-align:center;vertical-align:middle;">TANDA TANGAN PENERIMA</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; ?>
						@foreach($dinasregular->tim as $v)
							<tr>
								<td style="text-align: center;">{!! ++$i !!}</td>
								<td>{!! $v['nama'] !!}</td>
								<td style="text-align: center;">{!! strtoupper($v['pangkat']) !!} {!! $v['golongan'] !!}</td>
								<td style="text-align: right;">Rp.{!! $common->rupiah($v['total_harian']) !!}</td>
								<td></td>
								<td></td>
								<td style="text-align: right;">Rp.{!! $common->rupiah($v['total_harian']) !!}</td>
								<td></td>
							</tr>
						@endforeach
						<tr>
							<td style="text-align: center;"></td>
							<td>TRANSPORTASI</td>
							<td style="text-align: center;"></td>
							<td style="text-align: right;"></td>
							<td></td>
							<td style="text-align:right;">Rp.{!! $common->rupiah($dinasregular->total_transportasi['total']) !!}</td>
							<td style="text-align:right;">Rp.{!! $common->rupiah($dinasregular->total_transportasi['total']) !!}</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="6" style="text-align: center;"><b>JUMLAH</b></td>
							<td style="text-align: right;">Rp.{!! $common->rupiah($total) !!}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
				Terbilang : <i><b>{!! $common->terbilang($total) !!} rupiah *</b></i>
				<br><br>

				<table width="100%">
					<tr>
						<td width="25%"></td>
						<td width="25%">
							<center>
								<table cellpadding="2" cellspacing="2" style="width:30%;">
										<tr>
												<td width="10%" style="text-align: center;">
													Bandung, {!! Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y') !!}
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
													<td width="20%" style="text-align: center;">Setuju dibayar</td>
											</tr>
											<tr>
													<td width="20%" style="text-align: center;"><b>KUASA PENGGUNA ANGGARAN</b></td>
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
							<td width="25%">
									<table cellpadding="2" cellspacing="2" style="width:100%;">
										<tr>
													<td width="20%" style="text-align: center;">Lunas dibayar</td>
											</tr>
											<tr>
													<td width="20%" style="text-align: center;"><b>BENDAHARA PENGELUARAN PEMBANTU</b></td>
											</tr>
											<tr>
													<td width="10%" style="text-align: center;"><br><br><br><br></td>
											</tr>
											<tr>
													<td width="10%" style="text-align: center;">{!! $dinasregular->kegiatan->pegawai->nama !!}</td>
											</tr>
											<tr>
													<td width="10%" style="text-align: center;">{!! $dinasregular->kegiatan->pegawai->pangkat !!}</td>
											</tr>
											<tr>
													<td width="10%" style="text-align: center;">NIP. {!! $dinasregular->kegiatan->pegawai->nip !!}</td>
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
