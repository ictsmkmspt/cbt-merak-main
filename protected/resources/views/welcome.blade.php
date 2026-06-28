<?php use Carbon\Carbon; ?>

<?php
/*$tm = Carbon::today();
  $ts = new Carbon('2017-04-21');
  $interval = $tm->diff($ts);
  $interval =  $interval->format('%a');
  if($interval > 0){*/
?>
@extends('layouts/welcome')
@section('content')
<link rel="stylesheet" href="{{ url('/assets/assets/libs/sweetalert/dist/sweetalert.css') }}">
<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
<script src="{{ url('/assets/assets/libs/sweetalert/dist/sweetalert.min.js') }}"></script>
<script>
    // $( window ).on( "load", function() { swal("Terimakasih telah menggunakan aplikasi Ujian Tipamedia. Anda menggunakan aplikasi versi trial. Masa aktif aplikasi Anda adalah  hari lagi."); });
    $(document).ready(function() {


    });
</script>

<style>
    .video-container {
        position:relative;
        padding-bottom:56.25%;
        padding-top:30px;
        height:0;
        overflow:hidden;
    }

    .video-container iframe, .video-container object, .video-container embed {
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
    }
</style>

<?php
include(app_path() . '/functions/koneksi.php');
$conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM schools";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $namasekolah = $row["nama"];
        $logosekolah = $row['logo'];
    }
} else {
    $namasekolah = "";
}
//$conn->close();
?>

<div class="android-content mdl-layout__content" style="background-color:#f1f1f1;">
    <a name="top"></a>
    <div class="android-more-section">
        <div class="android-customized-section-text" style="padding: 0 0 0 0;">
                <div class="social-btns">
                    <a class="btn facebook" href="#"><i class="fa fa-facebook"></i></a>
                </div>
                <br>
                <div class="mdl-typography--font-light mdl-typography--display-1-color-contrast" style="text-align: center;">PAS GANJIL SMKM 2022/2023</div>
                <div class="mdl-typography--font-light mdl-typography--display-1-color-contrast" style="text-align: center;">DARING (CBT)</div>
        </div>
        <div class="android-card-container-green mdl-grid mdl-grid" style="justify-content: center;">
            <button class="btn-derek first" onclick="window.location='{{ url('guru') }}'">LOGIN GURU</button>
            <button class="btn-derek first" onclick="window.location='{{ url('lobby-siswa') }}'">LOGIN SISWA</button>
        </div>
    </div>
    
    {{-- <div class="android-card-container-green mdl-grid mdl-grid" style="justify-content: center;">
        <div class="mdl-typography--font-light" style="text-align: center;">
            <p>Informasi Kisi-kisi Soal, Jadwal, Persyaratan Ujian Sekolah Kelas XII</p>
            <button class="btn-derek first" onclick="window.location='{{ url('https://smkmuhsampit.id/sosialisasi_us/') }}'">Info US SMK 2020/2021</button>
        </div>
    </div> --}}
    
    <!-- <div style="text-align: center;">
        <h5>Tata Tertib US Teori Daring 2020/2021</h5>
        <div class="video-container">
            <iframe src ="{{ asset('/TataTertibUSTeori2020_21.pdf') }}"></iframe>
        </div>
    </div> -->

    <!-- <div style="padding-top:80px; text-align: center;">
        <h5>Jadwal US Daring 2020/2021</h5>
        <div class="video-container">
            <iframe src ="{{ asset('/JadwalUS2020_21.pdf') }}"></iframe>
        </div>
    </div> -->
@endsection
