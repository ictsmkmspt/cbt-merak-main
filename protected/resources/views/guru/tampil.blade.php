<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Ujian</title>
    <link rel="icon" href="{{ ('img/favicon.png') }}">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ url('assets_lama/bootstrap/css/bootstrap.min.css') }}"> --}}
		<script>
			function perhatian(){
				//$('#perhatian').removeClass('hidden');
				var element = document.getElementById("perhatian");
  			element.classList.remove("hidden");
			}
		</script>
		<style type="text/css" media="screen">
			#container 
			{
		    overflow:hidden;
			}

			#fancy_h1_wrap
			{
		    display:flex;
		    width:84%;
		    height:100%;
		    position:absolute;
		    top:10%;
			}
			
			body{
				background-color: darkgrey;
			}

			.cards {
					display: flex;

					/* Put a card in the next row when previous cards take all width */
					flex-wrap: wrap;

					margin-left: -8px;
					margin-right: -8px;
			}

			.cards__item {
					/* There will be 4 cards per row */
					flex-basis: 25%;

					padding-left: 8px;
					padding-right: 8px;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
		  <div class="table_responsive">
		  <table class="table table-bordered table-striped table-condensed table-responsive" style="background-color: #fff;">
		  	<tr>
					<th>No</th>
		  		<th>NUPSN</th>
		  		<th>Nama</th>
		  		{{-- <th>Asal Sekolah</th> --}}
		  		<th>Nilai</th>
		  	</tr>
			  <?php
			  	include(app_path() . '/functions/koneksi.php');
			  	$no = 0;
			  ?>

				<?php
				// mezt updated
				$idkelas = $jawabs[0]->id_kelas;
				$id_soal = $jawabs[0]->id_soal;
				$peserta_kelas = [];
				$qKelas = "SELECT id, nama  FROM kelas WHERE id='$idkelas'";
				$qKelasResult = $conn->query($qKelas);
				if ($qKelasResult->num_rows > 0) {
					while($rowkelas = $qKelasResult->fetch_assoc()) {
						$nama_kelas = $rowkelas["nama"];
					}
				}

				$qMapel = "SELECT paket, kkm from soals WHERE id='$id_soal'";
				$qMapelResult = $conn->query($qMapel);
				if ($qMapelResult->num_rows > 0 ) {
					while($rowMapel = $qMapelResult->fetch_assoc()) {
						$nama_mapel = $rowMapel["paket"];
						$kkm_soal = $rowMapel["kkm"];
					}
				}

				// end of updated
				?>
				<h4>{{$nama_kelas}} / {{$nama_mapel}}</h4>
				<h5>KKM : {{$kkm_soal}}</h5>
				<div class="alert alert-danger hidden" id="perhatian">
					<strong>Perhatian:</strong> Ada peserta yang tidak mengikuti ujian
					<span><a href="#miss">Lihat</a></span>
				</div>

		    @if($jawabs->count())
		    @foreach($jawabs as $jawab)
			    <?php
						$no++;
						$id_user = $jawab->id_user;
						$tuntas = 'black';

						//$peserta_kelas[] = $id_user;
						// push array if not exist
						if (!in_array($id_user, $peserta_kelas, true)) {
							array_push($peserta_kelas, $id_user);
						} 
						

			    	$conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
				    $conn->set_charset("utf8");
						if ($conn->connect_error) {
						  die("Connection failed: " . $conn->connect_error);
						}
						$sql = "SELECT sum(score) as total FROM jawabs WHERE id_kelas='$jawab->id_kelas' AND id_soal='$jawab->id_soal' AND id_user='$jawab->id_user'";
						$datatotal = $conn->query($sql);
						while ($row = mysqli_fetch_assoc($datatotal))
						{
						  $nilai = $row['total'];
							if ($nilai >= $kkm_soal) $tuntas = 'green';
						}
						
						$sql = "SELECT id, nama, no_induk FROM users WHERE id='$id_user'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								?>
										<tr style="color:<?php echo $tuntas ;?>">
											<td class="col-md-1">{{ $no }}</td>
											<td class="col-md-2"><b>{{ $row['no_induk'] }}</b></td>
											<td class="col-md-6">{{ $row['nama'] }}</td>
											{{-- <td>{{ $row['sekolah_asal'] }}</td> --}}
											<td class="col-md-2"><b><?= $nilai; ?></b></td>
										</tr>
								<?php 
							}
						} ?>
						
				@endforeach
				@endif
		    </table>
			</div>
				
			<br>
				<?php
				// cari siswa yg belum mengerjakan soal
				$peserta_ikut = [];
				$qMissHunter = "SELECT id, nama, sekolah_asal  FROM users WHERE id_kelas=$idkelas";
				$resMissHunter = $conn->query($qMissHunter);
				while($rowHunter = $resMissHunter->fetch_assoc()) {
					if ($rowHunter['sekolah_asal'] == "disabled") {
						//echo $rowHunter['nama'].'| ';
					} else {
						$peserta_ikut[] = $rowHunter['id'];
					}
				}
				?>
				<?php

				$dif_peserta = array_diff($peserta_ikut, $peserta_kelas);
				if (!empty($dif_peserta)) {
					echo '<script> perhatian(); </script>'
					?>
						<div id="table_responsive">
						<h4 id="miss">DAFTAR PESERTA TIDAK IKUT UJIAN</h4>
						<table class="table table-bordered table-striped table-condensed table-responsive" style="background-color: #fff;">
							<tr>
								<th>No</th>
								<th>NUPSN</th>
								<th>Nama</th>
								<th>Kehadiran</th>
							</tr>
					<?php
					$no2 = 1;
					$ids = join("','",$dif_peserta);
					$qDiff = "SELECT id, no_induk, nama FROM users WHERE id IN ('$ids')";
					$resDiff = $conn->query($qDiff);
					while($row = $resDiff->fetch_assoc()) {
						?>
							<tr>
								<td class="col-md-1">{{$no2}}</td>
								<td class="col-md-2"><b>{{ $row['no_induk']}}</b></td>
								<td class="col-md-6">{{ $row['nama']}}</td>
								<td class="col-md-2">Tidak Hadir</td>
							</tr>
						<?php
						$no2++;
					}
					?>
					</table>
					</div>
					<?php
				} else {
					?>
						<div class="alert alert-success">
							<strong>Congratz:</strong> Semua Peserta Kelas Telah Mengikuti Ujian
						</div>
					<?php
				}
				?>
		</div>
		<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
		{{-- <script src="{{ url('/js/jquery.backstretch.min.js') }}"></script> --}}
		<script>
			//$.backstretch("{{ url('/img/bg_guru.jpg') }}", {speed: 150});
			//function fun(){
		  //  $('#fancy_h1_wrap').css('top', '');
		  //  $('#fancy_h1_wrap').animate({top:"-100"}, 25000, fun);
			//}
			//fun();
		</script>
	</body>
</html>