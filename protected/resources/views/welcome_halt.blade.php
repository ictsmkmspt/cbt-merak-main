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

<?php
  include(app_path() . '/functions/koneksi.php');
  $conn = new mysqli($hostdb, $userdb, $passdb, $namedb);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM schools";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
  {{-- <div class="android-be-together-section mdl-typography--text-center">
    <div class="logo-font android-slogan">إِنَّ الَّذِينَ ءَامَنُوا وَعَمِلُوا الصَّالِحَاتِ أُولَئِكَ هُمْ خَيْرُ الْبَرِيَّةِ</div>
    <div class="logo-font android-sub-slogan">(Q.S 98:7)</div>
    <div class="logo-font android-sub-slogan">Selamat Datang di SMK Muhammadiyah Sampit</div>
  </div> --}}

  <div class="android-more-section">
    <div class="android-customized-section-text" style="padding: 0 0 0 0;">
      <a name="teacherlogin"></a>
      <div class="mdl-typography--font-light mdl-typography--display-1-color-contrast">Merak Computer Based Test</div>
      <p class="mdl-typography--font-light">
        Materi Ajar dan Ujian berbasis Web Aplikasi SMK Muhammadiyah Sampit
        <br>
        {{-- <a href="" class="android-link mdl-typography--font-light">Baca panduan menggunakan Merak CBT</a> --}}
      </p>
    </div>
    <div class="android-card-container mdl-grid mdl-grid" style="justify-content: center;">
      <div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
        <div class="mdl-card__media">
          <img src="./img/gurus.png">
        </div>
        <div class="mdl-card__title">
            <h4 class="mdl-card__title-text">Kelola sistem sebagai guru</h4>
        </div>
        <div class="mdl-card__supporting-text">
          <span class="mdl-typography--font-light mdl-typography--subhead">Media efektif para guru untuk mengelola bahan ajar & bahan uji siswa</span>
        </div>
        <div class="mdl-card__actions">
            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="{{ url('guru') }}">
              LOGIN GURU
              <i class="material-icons">chevron_right</i>
            </a>
        </div>
      </div>

      <a name="siswalogin"></a>
      <div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
        <div class="mdl-card__media">
          <img src="./img/siswas.png">
        </div>
        <div class="mdl-card__title">
            <h4 class="mdl-card__title-text">Sarana belajar siswa</h4>
        </div>
        <div class="mdl-card__supporting-text">
          <span class="mdl-typography--font-light mdl-typography--subhead">Siswa! Yuk mari belajar lebih efektif di sini. Lewat genggaman, materi ajar dan latihan ada di sini</span>
        </div>
        <div class="mdl-card__actions">
            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="{{ url('lobby-siswa') }}">
              login siswa
              <i class="material-icons">chevron_right</i>
            </a>
        </div>
      </div>
    </div>
  </div>
@endsection
